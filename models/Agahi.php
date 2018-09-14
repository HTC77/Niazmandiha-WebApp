<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_agahi".
 *
 * @property int $id
 * @property string $user_id
 * @property string $onvan
 * @property string $tozihat
 * @property string $price
 * @property string $pic
 * @property string $tarikh
 * @property int $taeed
 * @property string $city_id
 * @property string $mahale_id
 * @property string $cat_id
 */
class Agahi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $subCat_id;
    public static function tableName()
    {
        return 'tbl_agahi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'onvan', 'tozihat', 'tarikh', 'city_id', 'mahale_id', 'cat_id','subCat_id','price'], 'required','message'=>'{attribute} نمی تواند خالی باشد'],
            [['tozihat', 'pic'], 'string'],
            [['user_id','taeed','visit'], 'integer'],
            [['onvan', 'city_id', 'mahale_id', 'cat_id'], 'string', 'max' => 255],
            [['price'], 'string', 'max' => 50],
            [['tarikh'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'onvan' => 'عنوان',
            'tozihat' => 'توضیحات',
            'price' => 'قیمت ',
            'pic' => 'تصویر',
            'tarikh' => 'تاریخ',
            'taeed' => 'Taeed',
            'city_id' => 'شهر',
            'mahale_id' => 'محله',
            'cat_id' => 'دسته',
            'subCat_id' => 'زیر دسته',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(),['id'=>'user_id']);
    }
    public function getCat()
    {
        return $this->hasOne(Category::className(),['id'=>'cat_id']);
    }
    public function getMahale()
    {
        return $this->hasOne(Mahale::className(),['id'=>'mahale_id']);
    }
    public function getCity()
    {
        return $this->hasOne(City::className(),['id'=>'city_id']);
    }
    public function getReport()
    {
        return $this->hasMany(Reports::className(),['agahi_id'=>'id']);
    }
}
