<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%delivery}}".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 * @property integer $ua
 * @property integer $min
 * @property integer $discount
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%delivery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['ua', 'min', 'discount'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'ua' => Yii::t('app', 'Ua'),
            'min' => Yii::t('app', 'Min'),
            'discount' => Yii::t('app', 'Discount'),
        ];
    }

    public static function getListByOrder(){
        $model = self::find()->orderBy('id asc')->all();
        $r = [];
        foreach($model AS $v){
            $r[$v->id] = '<strong>'.$v->name.'</strong> ('.$v->text.')';
        }
        return $r;
    }
}
