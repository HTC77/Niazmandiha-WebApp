<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_mahale".
 *
 * @property int $id
 * @property string $city_id
 * @property string $name
 */
class Mahale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_mahale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'name'], 'required','message'=>'{attribute} نمی تواند خالی باشد!'],
            [['name'], 'string', 'max' => 150],
            [['name'], 'uniqueForCity'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'city_id' => 'نام شهر',
            'name' => 'محله',
        ];
    }
    public function uniqueForCity($attribute,$params, $validator)
    {
        $city_id=$this->city_id;
        $name=$this->name;
        if(Mahale::find()->where(['name'=>$name,'city_id'=>$city_id])->exists())
        {
            $validator->addError($this, $attribute, '{attribute}  "{value}" برای این شهر قبلاً ثبت شده است!');
        }
    }
}
