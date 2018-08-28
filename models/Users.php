<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_users".
 *
 * @property int $id
 * @property string $name
 * @property string $family
 * @property string $email
 * @property int $tel
 * @property int $password 
 * @property string $enum
 */
class Users extends \yii\db\ActiveRecord
{
    public $captcha;
    public $old_password;
    public $new_password;
    public $confirm_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'family', 'email', 'tel'], 'required','message'=>'{attribute} نباید خالی باشد.','on' => ['register','create','profile','update']],
            [['password','confirm_password'],'required','message'=>'{attribute} نباید خالی باشد.','on' => ['register','create']],
            [['captcha'],'required','message'=>'{attribute} نباید خالی باشد.','on' => ['register']],
            [['enum'],'required','message'=>'{attribute} نباید خالی باشد.','on' => ['create','update']],
            [['new_password','confirm_password'], 'required','message'=>'{attribute} نباید خالی باشد.','on' => ['newpwd']],
            [['old_password','new_password','confirm_password'], 'required','message'=>'{attribute} نباید خالی باشد.','on' => ['changepwd']],
            [['tel'], 'string', 'max' => 20,'message'=>'{attribute} معتبر نمی باشد.','on' => ['register','profile','create','update']],
            [['password'], 'string', 'max' => 5000,'message'=>'{attribute} معتبر نمی باشد.','on' => ['register','create']],
            [['name', 'family'], 'string', 'max' => 120,'message'=>'{attribute} معتبر نمی باشد.','on' => ['register','profile','create','update']],
            [['email'], 'email', 'message'=>'یک {attribute} معتبر وارد کنید.','on' => ['register','profile','create','update']],
            [['email'], 'unique','message'=>'این {attribute} قبلاً ثبت شده است.','on' => ['register','profile','create','update']],
            [['captcha'],'captcha','message'=>'{attribute} اشتباه است.','on' => ['register']],
            [['confirm_password'],'compare','compareAttribute' => 'password','message'=>'رمز های عبور مطابقت ندارند','on' => ['register','create']],
            [['old_password'],'findPasswords', 'skipOnEmpty' => false, 'skipOnError' => false,'on' => ['changepwd']],
            [['confirm_password'],'compare','compareAttribute' => 'new_password','message'=>'رمز های عبور مطابقت ندارند','on' => ['changepwd','newpwd']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام',
            'family' => 'نام خانوادگی',
            'email' => 'ایمیل',
            'tel' => 'تلفن',
            'password' => 'رمز عبور',
            'captcha'=>'کد امنیتی',
            'old_password'=>'رمز عبور فعلی',
            'new_password'=>'رمز عبور جدید',
            'confirm_password'=>'تأیید رمز عبور',
            'enum'=>'سطح دسترسی',
        ];
    }

    public function getAgahi()
    {
        return $this->hasMany(Agahi::className(),['user_id'=>'id']);
    }

    public function findPasswords($attribute,$params, $validator)
    {
        if(!$this->isValidPassword($this->old_password))
        {
            $validator->addError($this, $attribute, '{attribute} وارد شده با مقدار "{value}" اشتباه است!');
        }
    }
    private function isValidPassword($password)
    {
        if(Yii::$app->getSecurity()->validatePassword($password,Yii::$app->user->identity->password)):
            return true;
        else:
            return false;
        endif;
    }
}
