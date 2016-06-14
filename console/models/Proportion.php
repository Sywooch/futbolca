<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%proportion}}".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 *
 * @property CartItem[] $cartItems
 * @property ElementSize[] $elementSizes
 * @property OrderItem[] $orderItems
 */
class Proportion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%proportion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['size' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementSizes()
    {
        return $this->hasMany(ElementSize::className(), ['size' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['size' => 'id']);
    }
}
