<?php

namespace frontend\models;

use Yii;
use yii\bootstrap\Html;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property string $id
 * @property string $name
 * @property string $value
 * @property string $title
 */
class Settings extends \yii\db\ActiveRecord
{

    public static $settings = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    public static function footerTagsInTag(){
        $r = [];
        foreach(self::footerTags() AS $url => $name){
            $r[] = Html::a($name, ['tags/view', 'url' => $url], ['title' => Html::encode($name)]);
        }
        return $r;
    }

    public static function footerTags(){
        return [
            'kiev' => Yii::t('app', 'Киев'),
            'kharkov' => Yii::t('app', 'Харьков'),
            'donetsk' => Yii::t('app', 'Донецк'),
            'odessa' => Yii::t('app', 'Одесса'),
            'dnepropetrovsk' => Yii::t('app', 'Днепропетровск'),
            'zaporozhje' => Yii::t('app', 'Запорожье'),
            'vinnitsa' => Yii::t('app', 'Винница'),
            'zhytomir' => Yii::t('app', 'Житомир'),
            'ivano-frankovsk' => Yii::t('app', 'Ивано-Франковск'),
            'kirovograd' => Yii::t('app', 'Кировоград'),
            'kremenchug' => Yii::t('app', 'Кременчуг'),
            'krivoj-rog' => Yii::t('app', 'Кривой Рог'),
            'lugansk' => Yii::t('app', 'Луганск'),
            'lutsk' => Yii::t('app', 'Луцк'),
            'mariupol' => Yii::t('app', 'Мариуполь'),
            'nikolaev' => Yii::t('app', 'Николаев'),
            'poltava' => Yii::t('app', 'Полтава'),
            'rovno' => Yii::t('app', 'Ровно'),
            'simferopol' => Yii::t('app', 'Симферополь'),
            'sevastopol' => Yii::t('app', 'Севастополь'),
            'sumy' => Yii::t('app', 'Сумы'),
            'ternopol' => Yii::t('app', 'Тернополь'),
            'uzhgorod' => Yii::t('app', 'Ужгород'),
            'herson' => Yii::t('app', 'Херсон'),
            'hmelnitskij' => Yii::t('app', 'Хмельницкий'),
            'chernigov' => Yii::t('app', 'Чернигов'),
            'chernovtsy' => Yii::t('app', 'Черновцы')
        ];
    }

    public static function setSettings(){
        if(!self::$settings){
            $model = self::find()->all();
            foreach($model AS $v){
                self::$settings[$v->name] = $v->value;
            }
        }
        return self::$settings;
    }

    public static function getSettings($name = null){
        self::setSettings();
        if($name){
            return isset(self::$settings[$name]) ? self::$settings[$name] : null;
        }
        return self::$settings;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'title'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'title'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['name', 'value', 'title'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Имя'),
            'value' => Yii::t('app', 'Значение'),
            'title' => Yii::t('app', 'Описание'),
        ];
    }
}
