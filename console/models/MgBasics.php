<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "mg_basics".
 *
 * @property string $bs_id
 * @property string $bs_name
 * @property string $bs_photo
 * @property string $bs_size
 * @property integer $bs_insclad
 * @property integer $bs_home
 * @property string $bm_id
 * @property string $bs_preview
 * @property integer $b_top_px
 * @property integer $b_left_px
 * @property integer $b_price
 */
class MgBasics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_basics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bs_name', 'bs_photo', 'bs_size', 'bs_preview', 'b_price'], 'required'],
            [['bs_insclad', 'bs_home', 'bm_id', 'b_top_px', 'b_left_px', 'b_price'], 'integer'],
            [['bs_name', 'bs_photo', 'bs_size', 'bs_preview'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bs_id' => Yii::t('app', 'Bs ID'),
            'bs_name' => Yii::t('app', 'Bs Name'),
            'bs_photo' => Yii::t('app', 'Bs Photo'),
            'bs_size' => Yii::t('app', 'Bs Size'),
            'bs_insclad' => Yii::t('app', 'Bs Insclad'),
            'bs_home' => Yii::t('app', 'Bs Home'),
            'bm_id' => Yii::t('app', 'Bm ID'),
            'bs_preview' => Yii::t('app', 'Bs Preview'),
            'b_top_px' => Yii::t('app', 'B Top Px'),
            'b_left_px' => Yii::t('app', 'B Left Px'),
            'b_price' => Yii::t('app', 'B Price'),
        ];
    }
}
