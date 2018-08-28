<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property string $title
 * @property string $description
 * @property string $about
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'about'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'about' => 'About',
        ];
    }
}
