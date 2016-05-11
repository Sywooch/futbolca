<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%item_element}}".
 *
 * @property string $id
 * @property string $item
 * @property string $element
 * @property string $position
 *
 * @property Element $element0
 * @property Item $item0
 */
class ItemElement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_element}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'element'], 'required'],
            [['item', 'element', 'position'], 'integer']
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
            'element' => Yii::t('app', 'Element'),
            'position' => Yii::t('app', 'Position'),
        ];
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

    public static function getPos($item){
        $model = self::find()->where("item = :item", [':item' => $item])->all();
        if(!$model){
            return [];
        }
        $r = [];
        foreach($model AS $m){
            $r[$m->element] = $m->position;
        }
        return $r;
    }
}
