<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_blog".
 *
 * @property string $blog_id
 * @property string $blog_name
 * @property string $blog_uri
 * @property string $blog_description
 * @property string $blog_keywords
 * @property string $blog_smalltext
 * @property string $blog_text
 * @property string $blog_time
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_name', 'blog_uri', 'blog_description', 'blog_keywords', 'blog_smalltext', 'blog_text'], 'required'],
            [['blog_description', 'blog_keywords', 'blog_smalltext', 'blog_text'], 'string'],
            [['blog_time'], 'integer'],
            [['blog_name', 'blog_uri'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blog_id' => Yii::t('app', 'Blog ID'),
            'blog_name' => Yii::t('app', 'Blog Name'),
            'blog_uri' => Yii::t('app', 'Blog Uri'),
            'blog_description' => Yii::t('app', 'Blog Description'),
            'blog_keywords' => Yii::t('app', 'Blog Keywords'),
            'blog_smalltext' => Yii::t('app', 'Blog Smalltext'),
            'blog_text' => Yii::t('app', 'Blog Text'),
            'blog_time' => Yii::t('app', 'Blog Time'),
        ];
    }
}
