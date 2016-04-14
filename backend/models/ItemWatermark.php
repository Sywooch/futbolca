<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%item_watermark}}".
 *
 * @property string $id
 * @property string $item
 * @property string $name
 * @property string $position
 */
class ItemWatermark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_watermark}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['item', 'name'], 'required'],
            [['item', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Позиция'),
        ];
    }

    public function delOneImg($imgName){
        $imageIdDir = Yii::getAlias('@frontend/web/images/item').'/'.$this->item.'/';
        @unlink($imageIdDir.$imgName);
        return $imageIdDir.$imgName;
    }
}
