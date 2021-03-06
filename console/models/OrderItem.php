<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%order_item}}".
 *
 * @property string $id
 * @property string $orders
 * @property string $element
 * @property string $item
 * @property string $watermark
 * @property integer $counts
 * @property integer $price
 * @property string $size
 *
 * @property Order $orders0
 * @property Item $item0
 * @property Proportion $size0
 * @property Element $element0
 * @property ItemWatermark $watermark0
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orders', 'element', 'item'], 'required'],
            [['orders', 'element', 'item', 'watermark', 'counts', 'price', 'size'], 'integer'],
            [['orders'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['orders' => 'id']],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
            [['size'], 'exist', 'skipOnError' => true, 'targetClass' => Proportion::className(), 'targetAttribute' => ['size' => 'id']],
            [['element'], 'exist', 'skipOnError' => true, 'targetClass' => Element::className(), 'targetAttribute' => ['element' => 'id']],
            [['watermark'], 'exist', 'skipOnError' => true, 'targetClass' => ItemWatermark::className(), 'targetAttribute' => ['watermark' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'orders' => Yii::t('app', 'Orders'),
            'element' => Yii::t('app', 'Element'),
            'item' => Yii::t('app', 'Item'),
            'watermark' => Yii::t('app', 'Watermark'),
            'counts' => Yii::t('app', 'Counts'),
            'price' => Yii::t('app', 'Price'),
            'size' => Yii::t('app', 'Size'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasOne(Order::className(), ['id' => 'orders']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize0()
    {
        return $this->hasOne(Proportion::className(), ['id' => 'size']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement0()
    {
        return $this->hasOne(Element::className(), ['id' => 'element']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWatermark0()
    {
        return $this->hasOne(ItemWatermark::className(), ['id' => 'watermark']);
    }
}
