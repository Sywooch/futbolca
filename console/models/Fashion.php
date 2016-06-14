<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%fashion}}".
 *
 * @property string $id
 * @property string $old
 * @property string $name
 * @property integer $price
 * @property string $active
 *
 * @property Element[] $elements
 */
class Fashion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fashion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old', 'price'], 'integer'],
            [['name'], 'required'],
            [['active'], 'string'],
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
            'old' => Yii::t('app', 'Old'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElements()
    {
        return $this->hasMany(Element::className(), ['fashion' => 'id']);
    }
}
