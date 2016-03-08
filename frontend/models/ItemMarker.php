<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%item_marker}}".
 *
 * @property string $id
 * @property string $item
 * @property string $marker
 *
 * @property Item $item0
 * @property Marker $marker0
 */
class ItemMarker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_marker}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'marker'], 'required'],
            [['item', 'marker'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item' => Yii::t('app', 'Item'),
            'marker' => Yii::t('app', 'Marker'),
        ];
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
    public function getMarker0()
    {
        return $this->hasOne(Marker::className(), ['id' => 'marker']);
    }
}
