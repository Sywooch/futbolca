<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_prodact".
 *
 * @property string $pr_id
 * @property string $pr_sort
 * @property string $pr_name
 * @property string $pr_uri
 * @property string $pr_kode
 * @property string $pr_description
 * @property string $pr_keywords
 * @property string $pr_text
 * @property string $pr_wotemark
 * @property string $pr_price
 * @property integer $pr_active
 * @property integer $pr_in_home
 * @property integer $pr_top_px
 * @property integer $pr_left_px
 */
class Prodact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_prodact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pr_sort', 'pr_price', 'pr_active', 'pr_in_home', 'pr_top_px', 'pr_left_px'], 'integer'],
            [['pr_name', 'pr_uri', 'pr_kode', 'pr_description', 'pr_keywords', 'pr_text', 'pr_wotemark'], 'required'],
            [['pr_description', 'pr_keywords', 'pr_text'], 'string'],
            [['pr_name', 'pr_uri', 'pr_kode', 'pr_wotemark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pr_id' => Yii::t('app', 'Pr ID'),
            'pr_sort' => Yii::t('app', 'Pr Sort'),
            'pr_name' => Yii::t('app', 'Pr Name'),
            'pr_uri' => Yii::t('app', 'Pr Uri'),
            'pr_kode' => Yii::t('app', 'Pr Kode'),
            'pr_description' => Yii::t('app', 'Pr Description'),
            'pr_keywords' => Yii::t('app', 'Pr Keywords'),
            'pr_text' => Yii::t('app', 'Pr Text'),
            'pr_wotemark' => Yii::t('app', 'Pr Wotemark'),
            'pr_price' => Yii::t('app', 'Pr Price'),
            'pr_active' => Yii::t('app', 'Pr Active'),
            'pr_in_home' => Yii::t('app', 'Pr In Home'),
            'pr_top_px' => Yii::t('app', 'Pr Top Px'),
            'pr_left_px' => Yii::t('app', 'Pr Left Px'),
        ];
    }
}
