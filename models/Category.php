<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_category".
 *
 * @property int $id
 * @property string $onvan
 * @property string $tozihat
 * @property string $parent
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $child;
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['onvan',  'parent'], 'required','message'=>'{attribute} نمی تواند خالی باشد'],
            [['child'], 'required','message'=>'{attribute} نمی تواند خالی باشد','on'=>['child']],
            [['onvan', 'tozihat'], 'string', 'max' => 255],
            [['onvan'], 'uniq_cat','on'=>['cat']],
            [['onvan'], 'uniq_child','on'=>['child']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'onvan' => 'عنوان',
            'tozihat' => 'توضیحات (اختیاری)',
            'parent' => 'دسته',
            'child' => 'زیر دسته',
        ];
    }
    public function getparents()
    {
        return $this->hasOne(Category::className(),['id'=>'parent']);
    }

    public function uniq_cat($attribute,$params, $validator)
    {
        $onvan=$this->onvan;
        $id=$this->id;
        if($id){
            if(Category::find()->where(['onvan'=>$onvan,'parent'=>'y'])->andWhere(['<>','id',$id])->exists())
            {
                $validator->addError($this, $attribute, '{attribute}  "{value}" قبلاً ثبت شده است!');
            }
        }
        else{
            if(Category::find()->where(['onvan'=>$onvan,'parent'=>'y'])->exists())
            {
                $validator->addError($this, $attribute, '{attribute}  "{value}" قبلاً ثبت شده است!');
            }
        }
    }
    public function uniq_child($attribute,$params, $validator)
    {   $parent=$this->parent;
        $onvan=$this->onvan;
        $id=$this->id;
        if($id){
            if(Category::find()->where(['onvan'=>$onvan,'parent'=>$parent])->andWhere(['<>','id',$id])->exists())
            {
                $validator->addError($this, $attribute, '{attribute}  "{value}" برای این دسته قبلاً ثبت شده است!');
            }
        }
        else{
            if(Category::find()->where(['onvan'=>$onvan,'parent'=>$parent])->exists())
            {
                $validator->addError($this, $attribute, '{attribute}  "{value}" برای این دسته قبلاً ثبت شده است!');
            }
        }
    }
}
