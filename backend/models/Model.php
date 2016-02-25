<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%model}}".
 *
 * @property string $id
 * @property string $name
 * @property string $size
 * @property integer $stock
 * @property integer $home
 * @property string $fashion
 * @property integer $toppx
 * @property integer $leftpx
 * @property integer $price
 * @property integer $increase
 * @property string $photo
 *
 * @property Fashion $fashion0
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'fashion', 'photo'], 'required'],
            [['stock', 'home', 'fashion', 'toppx', 'leftpx', 'price', 'increase'], 'integer'],
            [['name', 'size', 'photo'], 'string', 'max' => 255],
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
            'size' => Yii::t('app', 'Size'),
            'stock' => Yii::t('app', 'Stock'),
            'home' => Yii::t('app', 'Home'),
            'fashion' => Yii::t('app', 'Fashion'),
            'toppx' => Yii::t('app', 'Toppx'),
            'leftpx' => Yii::t('app', 'Leftpx'),
            'price' => Yii::t('app', 'Price'),
            'increase' => Yii::t('app', 'Increase'),
            'photo' => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFashion0()
    {
        return $this->hasOne(Fashion::className(), ['id' => 'fashion']);
    }
}
