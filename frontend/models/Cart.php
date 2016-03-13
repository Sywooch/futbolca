<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $id
 * @property string $user
 * @property string $code
 * @property string $created
 *
 * @property User $user0
 * @property CartItem[] $cartItems
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user'], 'integer'],
            [['code'], 'required'],
            [['created'], 'safe'],
            [['code'], 'string', 'max' => 64],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'Пользователь'),
            'code' => Yii::t('app', 'ИНН'),
            'created' => Yii::t('app', 'Создано'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['cart' => 'id']);
    }

    public static function del(){
        $data = date("Y-m-d H:i:s", (time() - 60 * 60 * 24 * 365));
        self::deleteAll("created <= :created", [':created' => $data]);
    }

    public static function sunAndCount($cart){
        $count = 0;
        $sum = 0;
        $items = CartItem::find()->where("cart = :cart", [':cart' => $cart->id])->all();
        foreach($items AS $item){
            $count += $item->counts;
            $sum += ($item->counts * $item->item0->getAllPrice($item->element0));
        }
        $r = ['count' => $count, 'sum' => $sum];
        return $r;
    }

    public static function generateCode(){
        return md5(time().'|'.(int)Yii::$app->user->isGuest.rand(1,9));
    }

    public static function setNewUser(){
        $cookies = Yii::$app->response->cookies;
        $cookies->readOnly = false;
        $model = new self();
        if(!Yii::$app->user->isGuest){
            $model->user = Yii::$app->user->id;
        }
        $model->code = self::generateCode();
        $model->created = date("Y-m-d H:i:s");
        if($model->save()){
            $cookies->add(new \yii\web\Cookie([
                'name' => Yii::$app->params['cookieNameCart'],
                'value' => $model->code,
                'expire' => (time() + 60 * 60 * 24 * 365),
                'path' => '/',
                'httpOnly' => false,
            ]));
            return $model;
        }
        return null;
    }

    public static function getCartId(){
        self::del();
        $r = null;
        $cookies = Yii::$app->request->cookies;
        $cookies->readOnly = false;
        $cookie = $cookies->get(Yii::$app->params['cookieNameCart']);
        $model = self::find();
        if(!Yii::$app->user->isGuest){
            $model->where("user = :user", [':user' => Yii::$app->user->id]);
            $r = $model->one();
        }elseif($cookie !== null){
            $model->where("code = :code", [':code' => $cookie->value]);
            $r = $model->one();
        }else{
            return self::setNewUser();
        }
        if(!$r){
            return self::setNewUser();
        }
        if($cookie === null){
            $cookies->add(new \yii\web\Cookie([
                'name' => Yii::$app->params['cookieNameCart'],
                'value' => $r->code,
                'expire' => (time() + 60 * 60 * 24 * 365),
                'path' => '/',
                'httpOnly' => false,
            ]));
        }else{
            $r->created = date("Y-m-d H:i:s");
            $r->save();
            $cookie->expire = (time() + 60 * 60 * 24 * 365);
            $cookies->add($cookie);
        }
        return $r;
    }

    public static function cartCountItem($cart, $noCache = false){
        $key = md5($cart->code);
        $htmlCache = 120;
        if($noCache){
            $data = self::sunAndCount($cart);
            Yii::$app->cache->set($key, $data, $htmlCache);
            return $data;
        }
        $data = Yii::$app->cache->get($key);
        if($data === false) {
            $data = self::sunAndCount($cart);
            Yii::$app->cache->set($key, $data, $htmlCache);
        }
        return $data;
    }
}
