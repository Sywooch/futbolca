<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "mg_podcat".
 *
 * @property string $p_id
 * @property string $p_name
 * @property string $p_uri
 * @property string $p_description
 * @property string $p_keywords
 * @property string $p_text
 * @property string $p_parent
 * @property string $p_position
 * @property string $p_text2
 */
class Podcat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_podcat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_name', 'p_uri', 'p_description', 'p_keywords', 'p_text', 'p_text2'], 'required'],
            [['p_description', 'p_keywords', 'p_text', 'p_text2'], 'string'],
            [['p_parent', 'p_position'], 'integer'],
            [['p_name', 'p_uri'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'p_id' => Yii::t('app', 'P ID'),
            'p_name' => Yii::t('app', 'P Name'),
            'p_uri' => Yii::t('app', 'P Uri'),
            'p_description' => Yii::t('app', 'P Description'),
            'p_keywords' => Yii::t('app', 'P Keywords'),
            'p_text' => Yii::t('app', 'P Text'),
            'p_parent' => Yii::t('app', 'P Parent'),
            'p_position' => Yii::t('app', 'P Position'),
            'p_text2' => Yii::t('app', 'P Text2'),
        ];
    }
}
