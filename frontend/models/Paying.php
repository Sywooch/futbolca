<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%paying}}".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $img
 */
class Paying extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%paying}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['name', 'img'], 'string', 'max' => 255],
            [['name'], 'unique']
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
            'img' => Yii::t('app', 'Img'),
        ];
    }

    public static function getList(){
        return ArrayHelper::map(self::find()->orderBy('id asc')->all(), 'id', 'name');
    }
}
