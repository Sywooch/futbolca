<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\CartItem;
use frontend\models\Element;
use frontend\models\Item;
use frontend\models\ItemWatermark;
use frontend\models\Order;
use frontend\models\OrderItem;
use frontend\models\Proportion;
use frontend\models\UserDescription;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use Yii;

class CartController extends \yii\web\Controller
{
    public function actionClear()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        $cart = Cart::getCartId();
        if(!$cart){
            throw new BadRequestHttpException(Yii::t('app', 'No cart'));
        }
        $cart->delete();
        Yii::$app->response->format = 'json';
        return ['e' => 0];
    }

    public function actionContents()
    {
        $cart = Cart::getCartId();
        if(!$cart){
            throw new BadRequestHttpException(Yii::t('app', 'No cart'));
        }
        $items = CartItem::find()->where("cart = :cart", [':cart' => $cart->id])->orderBy('id desc')->all();
        if(!$items){
            throw new BadRequestHttpException(Yii::t('app', 'Нет товаров!'));
        }
        $order = new Order();
        if(!Yii::$app->user->isGuest){
            $userDescription = UserDescription::find()->where("user = :user", [':user' => Yii::$app->user->id])->one();
            $order->name = $userDescription->name;
            $order->soname = $userDescription->soname;
            $order->phone = $userDescription->phone;
            $order->adress = $userDescription->adress;
            $order->code = $userDescription->code;
            $order->city = $userDescription->city;
            $order->country = $userDescription->country;
            $order->agent = $userDescription->agent;
            $order->email = Yii::$app->user->identity->email;
            $order->user = Yii::$app->user->id;
        }
        if ($order->load(Yii::$app->request->post())) {
            if($order->validate()) {
                $order->data_start = date("Y-m-d H:i:s");
                $order->save();
                foreach($items AS $item){
                    $itemOrder = new OrderItem();
                    $itemOrder->orders =  $order->id;
                    $itemOrder->element =  $item->element;
                    $itemOrder->item =  $item->item;
                    $itemOrder->watermark =  $item->watermark;
                    $itemOrder->counts =  $item->counts;
                    $itemOrder->price =  $item->price;
                    $itemOrder->size =  $item->size;
                    $itemOrder->save();
                }
                $itemId = ArrayHelper::map($items, 'id', 'id');
                CartItem::deleteAll(['in', 'id', $itemId]);
                Cart::cartCountItem($cart, true);
                if(!Yii::$app->user->isGuest){
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                    return $this->redirect(Url::toRoute(['order/'.$order->id]));
                }else{
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
                    return $this->redirect(Url::toRoute(['cart/index']));
                }
            }
        }
        return $this->render('contents', [
            'items' => $items,
            'cart' => $cart,
            'order' => $order,
        ]);
    }

    public function actionIndex()
    {
        $cart = Cart::getCartId();
        if(!$cart){
            throw new BadRequestHttpException(Yii::t('app', 'No cart'));
        }
        if(isset($_POST['CartDelete']) || isset($_POST['count'])){
            if(isset($_POST['CartDelete']) && sizeof($_POST['CartDelete']) > 0) {
                CartItem::deleteAll("id IN (:id) AND cart = :cart", [
                    ':cart' => $cart->id,
                    ':id' => join('\', \'', $_POST['CartDelete']),
                ]);
            }
            if(isset($_POST['count']) && sizeof($_POST['count']) > 0) {
                foreach ($_POST['count'] AS $idItem => $counts) {
                    $counts = (int)$counts;
                    $idItem = (int)$idItem;
                    if ($counts <= 0) {
                        $counts = 1;
                    }
                    CartItem::updateAll(['counts' => $counts], "id = :id AND cart = :cart", [
                        ':cart' => $cart->id,
                        ':id' => $idItem,
                    ]);
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно сохраненно!'));
            return $this->refresh();
        }
        $items = CartItem::find()->where("cart = :cart", [':cart' => $cart->id])->orderBy('id desc')->all();
        return $this->render('index', [
            'items' => $items,
            'cart' => $cart,
        ]);
    }

    public function actionAdd()
    {
        if(!Yii::$app->request->isAjax){
            throw new BadRequestHttpException(Yii::t('app', 'Not ajax found'));
        }
        Yii::$app->response->format = 'json';
        $cart = Cart::getCartId();
        if(!$cart){
            return ['e' => 1, 'msg' => Yii::t('app', 'Ошибка создания корзины')];
        }
        $currentItem = Item::findOne((int)Yii::$app->request->post('item'));
        if(!$currentItem){
            return ['e' => 1, 'msg' => Yii::t('app', 'Нет такого товара')];
        }
        $element = Element::findOne((int)Yii::$app->request->post('element'));
        if(!$element){
            return ['e' => 1, 'msg' => Yii::t('app', 'Нет такой основы')];
        }
        $size = Proportion::findOne((int)Yii::$app->request->post('size'));
        if(!$size){
            return ['e' => 1, 'msg' => Yii::t('app', 'Нет такого размера')];
        }
        $watermark = ItemWatermark::find()->where("id = :id AND item = :item", [
            ':id' => (int)Yii::$app->request->post('watermark'),
            ':item' => $currentItem->id,
        ])->one();
        if(!$watermark){
            return ['e' => 1, 'msg' => Yii::t('app', 'Нет такого наложения')];
        }
        $item = CartItem::find()->where("item = :item AND cart = :cart AND element = :element AND watermark = :watermark AND size = :size", [
            ':item' => $currentItem->id,
            ':cart' => $cart->id,
            ':element' =>  $element->id,
            ':watermark' => $watermark->id,
            ':size' => $size->id,
        ])->one();
        if(!$item){
            $item = new CartItem();
            $item->item = $currentItem->id;
            $item->cart = $cart->id;
            $item->element = $element->id;
            $item->watermark = $watermark->id;
            $item->size = $size->id;
        }
        $item->counts = Yii::$app->request->post('count') > 0 ? (int)Yii::$app->request->post('count') : 1;
        $item->price = (int)$currentItem->getAllPrice($element) * $item->counts;
        if($item->validate()){
            $item->save(false);
            $data = Cart::cartCountItem($cart, true);
            return [
                'e' => 0,
                'counts' => (int)$data['count'],
                'price' => Yii::$app->formatter->asInteger((int)$data['sum']),
                'msg' => Yii::t('app', 'Товар "{item}" успешно добавлен в корзину!', ['item' => $currentItem->name])
            ];
        }
        return ['e' => 1, 'msg' => Yii::t('app', 'Ошибка сохранения')];
    }

}
