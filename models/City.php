<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_city".
 *
 * @property int $id
 * @property string $latin_name
 * @property string $persian_name
 */
class City extends \yii\db\ActiveRecord
{
    public $mahale;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['persian_name'], 'required','message'=>'{attribute} نباید خالی باشد.'],
            [['latin_name'], 'required','message'=>'نام لاتین نباید خالی باشد.'],
            [['latin_name', 'persian_name'], 'string', 'max' => 150],
            [['latin_name'], 'unique','message'=>'این نام لاتین قبلاً ثبت شده است.'],
            [['persian_name'], 'unique','message'=>'این {attribute} قبلاً ثبت شده است.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'latin_name' => 'نام لاتین شهر (برای نمایش در URL)',
            'persian_name' => 'نام فارسی شهر',
            'mahale'=>'نام محله',
        ];
    }
}
