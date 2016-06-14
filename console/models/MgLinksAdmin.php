<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "mg_links_admin".
 *
 * @property string $links_title
 * @property string $links_id
 * @property string $links_name
 * @property string $links_ankor
 * @property string $links_html
 */
class MgLinksAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_links_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['links_title', 'links_name', 'links_ankor', 'links_html'], 'required'],
            [['links_title', 'links_name', 'links_ankor', 'links_html'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'links_title' => Yii::t('app', 'Links Title'),
            'links_id' => Yii::t('app', 'Links ID'),
            'links_name' => Yii::t('app', 'Links Name'),
            'links_ankor' => Yii::t('app', 'Links Ankor'),
            'links_html' => Yii::t('app', 'Links Html'),
        ];
    }
}
