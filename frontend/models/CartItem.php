<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%cart_item}}".
 *
 * @property string $id
 * @property string $cart
 * @property string $element
 * @property string $item
 * @property integer $counts
 * @property integer $price
 * @property string $size
 *
 * @property Proportion $size0
 * @property Cart $cart0
 * @property Element $element0
 * @property Item $item0
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
            [['cart', 'element', 'item'], 'required'],
            [['cart', 'element', 'item', 'counts', 'price', 'size'], 'integer']
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
            'counts' => Yii::t('app', 'Counts'),
            'price' => Yii::t('app', 'Price'),
            'size' => Yii::t('app', 'Size'),
        ];
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
}
