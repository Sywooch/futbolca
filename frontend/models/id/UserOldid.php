<?php

namespace frontend\models\id;

use Yii;

/**
 * This is the model class for table "{{%user_oldid}}".
 *
 * @property string $id
 * @property string $old
 */
class UserOldid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_oldid}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'old'], 'required'],
            [['id', 'old'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'old' => Yii::t('app', 'Old'),
        ];
    }
}
