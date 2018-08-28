<?php

namespace app\models;
use Yii;
class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public static $Find;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        self::$Find=Users::Find()->where(['id'=>$id])->One();
        if(self::$Find!=null):
            $USER['id']=self::$Find->id;
            $USER['username']=self::$Find->email;
            $USER['password']=self::$Find->password;
            $USER['authKey']=self::$Find->id.'authKey';
            $USER['accessToken']=self::$Find->id.'-token';
            Yii::$app->session['user_id']=self::$Find->id;
            Yii::$app->session['enum']=self::$Find->enum;
            return new static($USER);
        else:
            return null;
        endif;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        self::$Find=Users::Find()->where(['email'=>$username])->One();
        if(self::$Find!=null):
            $USER['id']=self::$Find->id;
            $USER['username']=self::$Find->email;
            $USER['password']=self::$Find->password;
            $USER['authKey']=self::$Find->id.'authKey';
            $USER['accessToken']=self::$Find->id.'-token';
            Yii::$app->session['user_id']=self::$Find->id;
            Yii::$app->session['enum']=self::$Find->enum;
            return new static($USER);
        else:
            return null;
        endif;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if(Yii::$app->getSecurity()->validatePassword($password,self::$Find->password)):
            return true;
        else:
            return false;
        endif;
    }
}
