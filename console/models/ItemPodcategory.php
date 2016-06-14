<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%item_podcategory}}".
 *
 * @property string $id
 * @property string $item
 * @property string $podcategory
 *
 * @property Item $item0
 * @property Podcategory $podcategory0
 */
class ItemPodcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_podcategory}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item', 'podcategory'], 'required'],
            [['item', 'podcategory'], 'integer'],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
            [['podcategory'], 'exist', 'skipOnError' => true, 'targetClass' => Podcategory::className(), 'targetAttribute' => ['podcategory' => 'id']],
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
            'podcategory' => Yii::t('app', 'Podcategory'),
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
    public function getPodcategory0()
    {
        return $this->hasOne(Podcategory::className(), ['id' => 'podcategory']);
    }
}
