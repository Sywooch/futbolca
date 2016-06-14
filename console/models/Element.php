<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%element}}".
 *
 * @property string $id
 * @property string $old
 * @property integer $position
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
 * @property CartItem[] $cartItems
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
            [['old', 'position', 'stock', 'home', 'fashion', 'toppx', 'leftpx', 'price', 'increase'], 'integer'],
            [['name', 'fashion'], 'required'],
            [['name', 'size', 'photo'], 'string', 'max' => 255],
            [['fashion'], 'exist', 'skipOnError' => true, 'targetClass' => Fashion::className(), 'targetAttribute' => ['fashion' => 'id']],
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
            'position' => Yii::t('app', 'Position'),
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
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['element' => 'id']);
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
