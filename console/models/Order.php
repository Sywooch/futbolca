<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $old
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
            [['old', 'user', 'payment', 'delivery', 'status'], 'integer'],
            [['data_start', 'data_finish'], 'safe'],
            [['name', 'email', 'phone', 'adress', 'payment', 'delivery'], 'required'],
            [['agent', 'coment_admin'], 'string'],
            [['name', 'soname', 'email', 'phone', 'adress', 'code', 'city', 'country', 'region', 'fax', 'icq', 'skape'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'old' => Yii::t('app', 'Old'),
            'data_start' => Yii::t('app', 'Data Start'),
            'data_finish' => Yii::t('app', 'Data Finish'),
            'user' => Yii::t('app', 'User'),
            'name' => Yii::t('app', 'Name'),
            'soname' => Yii::t('app', 'Soname'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'adress' => Yii::t('app', 'Adress'),
            'code' => Yii::t('app', 'Code'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Country'),
            'payment' => Yii::t('app', 'Payment'),
            'delivery' => Yii::t('app', 'Delivery'),
            'agent' => Yii::t('app', 'Agent'),
            'region' => Yii::t('app', 'Region'),
            'fax' => Yii::t('app', 'Fax'),
            'icq' => Yii::t('app', 'Icq'),
            'skape' => Yii::t('app', 'Skape'),
            'status' => Yii::t('app', 'Status'),
            'coment_admin' => Yii::t('app', 'Coment Admin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['orders' => 'id']);
    }
}
