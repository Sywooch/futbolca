<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "mg_link_tags".
 *
 * @property string $lt_id
 * @property string $lt_id_metky
 * @property string $lt_id_tovar
 */
class LinkTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_link_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lt_id_metky', 'lt_id_tovar'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lt_id' => Yii::t('app', 'Lt ID'),
            'lt_id_metky' => Yii::t('app', 'Lt Id Metky'),
            'lt_id_tovar' => Yii::t('app', 'Lt Id Tovar'),
        ];
    }
}
