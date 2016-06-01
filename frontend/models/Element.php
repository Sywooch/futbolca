<?php

namespace frontend\models;

use common\UrlHelper;
use Yii;

/**
 * This is the model class for table "{{%element}}".
 *
 * @property string $id
 * @property string $old
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
 * @property ElementSize[] $elementSizes
 * @property Item[] $items
 * @property ItemElement[] $itemElements
 * @property OrderItem[] $orderItems
 */
class Element extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%element}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'photo'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name', 'photo'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name', 'fashion'], 'required'],
            [['stock', 'home', 'fashion', 'toppx', 'leftpx', 'price', 'increase', 'old'], 'integer'],
            [['name', 'size', 'photo'], 'string', 'max' => 255]
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementSizes()
    {
        return $this->hasMany(ElementSize::className(), ['element' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['element' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemElements()
    {
        return $this->hasMany(ItemElement::className(), ['element' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['element' => 'id']);
    }

    public function getImageLink($mini = false){
        if(!$this->photo){
            return $this->photo;
        }
        return UrlHelper::home(true).'images/element/'.$this->id.'/'.($mini ? 'mini_' : '').$this->photo;
    }

    public static function getByItem($elementId, $item = null, $currentFashion = 0){
        $currentFashion = (int)$currentFashion;
        $model = self::find();
        $model->distinct();
        $model->where(['in', 'id', $elementId]);
        if($item){
            $model->with(['fashion0']);
            if($currentFashion > 0){
                $model->andWhere("fashion = :fashion", [':fashion' => $currentFashion]);
            }else{
                $model->andWhere("fashion = :fashion", [':fashion' => $item->element0->fashion]);
            }
            $model->andWhere("id <> :id", [':id' => $item->element]);

        }
        $model->orderBy('fashion asc, name asc');
        return $model->all();
    }

    public function uploadByConver($img, $mini = false){ // _mini
        if(!is_dir(Yii::getAlias('@frontend/web/images/element'))){
            mkdir(Yii::getAlias('@frontend/web/images/element'), 0777);
        }
        if(!is_dir(Yii::getAlias('@frontend/web/images/element/').$this->id)){
            mkdir(Yii::getAlias('@frontend/web/images/element/').$this->id, 0777);
        }
        $imgDirName = Yii::getAlias('@frontend/web/images/element/').$this->id.'/';
        if($mini){
            @copy(str_replace('.jpg', '_mini.jpg', $img), $imgDirName.'mini_'.$this->photo);
        }else{
            @copy($img, $imgDirName.$this->photo);
        }
    }
}
