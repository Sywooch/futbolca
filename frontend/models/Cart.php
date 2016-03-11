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
            'user' => Yii::t('app', 'User'),
            'code' => Yii::t('app', 'Code'),
            'created' => Yii::t('app', 'Created'),
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
}
