<?php

namespace backend\models;

use common\UrlHelper;
use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $data_start
 * @property string $data_finish
 * @property string $user
 * @property string $name
 * @property string $soname
 * @property string $email
 * @property string $phone
 * @property string $adress
 * @property string $code
 * @property string $city
 * @property string $country
 * @property string $payment
 * @property string $delivery
 * @property string $agent
 * @property string $region
 * @property string $fax
 * @property string $icq
 * @property string $skape
 * @property integer $status
 * @property string $coment_admin
 *
 * @property OrderItem[] $orderItems
 * @property User[] $user0
 * @property Delivery $delivery0
 * @property Paying $payment0
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_start', 'data_finish'], 'safe'],
            [['user', 'payment', 'delivery', 'status'], 'integer'],
            [['name', 'email', 'phone', 'adress', 'payment', 'delivery'], 'required'],
            [['agent', 'coment_admin'], 'string'],
            [['name', 'soname', 'email', 'phone', 'adress', 'code', 'city', 'country', 'region', 'fax', 'icq', 'skape'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data_start' => Yii::t('app', 'Data Start'),
            'data_finish' => Yii::t('app', 'Data Finish'),
            'user' => Yii::t('app', 'User'),
            'name' => Yii::t('app', 'Имя'),
            'soname' => Yii::t('app', 'Фамилия'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'adress' => Yii::t('app', 'Adress'),
            'code' => Yii::t('app', 'Индекс'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Область'),
            'payment' => Yii::t('app', 'Payment'),
            'delivery' => Yii::t('app', 'Delivery'),
            'agent' => Yii::t('app', 'Комментарий'),
            'region' => Yii::t('app', 'Регион'),
            'fax' => Yii::t('app', 'Fax'),
            'icq' => Yii::t('app', 'Icq'),
            'skape' => Yii::t('app', 'Skype'),
            'status' => Yii::t('app', 'Status'),
            'coment_admin' => Yii::t('app', 'Comment Admin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['orders' => 'id']);
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
    public function getPayment0()
    {
        return $this->hasOne(Paying::className(), ['id' => 'payment']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery0()
    {
        return $this->hasOne(Delivery::className(), ['id' => 'delivery']);
    }

    public static function statusList(){
        return [
            1 => Yii::t('app', 'выполняется'),
            0 => Yii::t('app', 'в обработке'),
            2 => Yii::t('app', 'на доставку'),
            3 => Yii::t('app', 'отправлен'),
            4 => Yii::t('app', 'получен'),
            5 => Yii::t('app', 'не дозвонились'),
            6 => Yii::t('app', 'отменен'),
            7 => Yii::t('app', 'не оформлен'),
            8 => Yii::t('app', 'ожидает оплату'),
            9 => Yii::t('app', 'выполнен')
        ];
    }

    public static function getStatusName($id){
        return isset(self::statusList()[$id]) ? self::statusList()[$id] : null;
    }

    public function nameStatus(){
        return isset(self::statusList()[$this->status]) ? self::statusList()[$this->status] : null;
    }

    public function getListItemsMini(){
        $r = [];
        $ollPrice = 0;
        if($this->orderItems){
            $r[] = '<strong>'.Yii::t('app', 'Название').' | '.Yii::t('app', 'Количество').' | '.Yii::t('app', 'Размер').'</strong>';
            foreach($this->orderItems AS $orderItems){
                $ollPrice += ($orderItems->counts * $orderItems->price);
                $r[] = '<a href="'.UrlHelper::ItemUrlForAdmin($orderItems->item0->url).'" target="_blank">'.$orderItems->item0->name.' ('.$orderItems->element0->fashion0->name.' '.$orderItems->element0->name.')</a> | '.$orderItems->counts.' | '.$orderItems->size0->name;
            }
            $r[] = '<strong>'.Yii::t('app', 'Полная сумма').': '.Yii::$app->formatter->asCurrency($ollPrice, 'UAH').'</strong>';
        }
        return $r;
    }

    public function getListItems(){
        $r = [];
        $ollPrice = 0;
        if($this->orderItems){
            $r[] = '<strong>'.Yii::t('app', 'Название').' | '.Yii::t('app', 'Количество').' | '.Yii::t('app', 'Цена за 1').' | '.Yii::t('app', 'Размер').' | '.Yii::t('app', 'Общая цена').'</strong>';
            foreach($this->orderItems AS $orderItems){
                $ollPrice += ($orderItems->counts * $orderItems->price);
                $r[] = '<a href="'.UrlHelper::ItemUrlForAdmin($orderItems->item0->url).'" target="_blank">'.$orderItems->orders0->name.' ('.$orderItems->element0->fashion0->name.' '.$orderItems->element0->name.')</a> | '.$orderItems->counts.' | '.$orderItems->price.' | '.$orderItems->size0->name.' | '.($orderItems->counts * $orderItems->price);
            }
            $r[] = '<strong>'.Yii::t('app', 'Полная сумма').': '.Yii::$app->formatter->asCurrency($ollPrice, 'UAH').'</strong>';
        }
        return $r;
    }

    public function getListItemsForExcel(){
        $r = [];
        $ollPrice = 0;
        if($this->orderItems){
            foreach($this->orderItems AS $orderItems){
                $ollPrice += ($orderItems->counts * $orderItems->price);
                $r[] = ''.UrlHelper::ItemUrlForAdmin($orderItems->item0->url).' | '.$orderItems->orders0->name.' ('.$orderItems->element0->fashion0->name.' '.$orderItems->element0->name.') | '.$orderItems->counts.' | '.$orderItems->price.' | '.$orderItems->size0->name.' | '.($orderItems->counts * $orderItems->price);
            }
            $r[] = "\n\t ".Yii::t('app', 'Полная сумма').': '.Yii::$app->formatter->asCurrency($ollPrice, 'UAH').'';
        }
        return $r;
    }
}
