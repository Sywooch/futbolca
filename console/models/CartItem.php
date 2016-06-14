<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%cart_item}}".
 *
 * @property string $id
 * @property string $cart
 * @property string $element
 * @property string $item
 * @property string $watermark
 * @property integer $counts
 * @property integer $price
 * @property string $size
 *
 * @property Cart $cart0
 * @property Element $element0
 * @property Item $item0
 * @property Proportion $size0
 * @property ItemWatermark $watermark0
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cart', 'element', 'item', 'watermark'], 'required'],
            [['cart', 'element', 'item', 'watermark', 'counts', 'price', 'size'], 'integer'],
            [['cart'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart' => 'id']],
            [['element'], 'exist', 'skipOnError' => true, 'targetClass' => Element::className(), 'targetAttribute' => ['element' => 'id']],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
            [['size'], 'exist', 'skipOnError' => true, 'targetClass' => Proportion::className(), 'targetAttribute' => ['size' => 'id']],
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
            'cart' => Yii::t('app', 'Cart'),
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
    public function getCart0()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart']);
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
    public function getWatermark0()
    {
        return $this->hasOne(ItemWatermark::className(), ['id' => 'watermark']);
    }
}
