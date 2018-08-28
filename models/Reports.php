<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_reports".
 *
 * @property int $id
 * @property string $report_id
 * @property int $agahi_id
 * @property string $ip
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'agahi_id', 'ip'], 'required'],
            [['agahi_id'], 'integer'],
            [['report_id'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'agahi_id' => 'شناسه آگهی',
            'ip' => 'آی پی ثبت کننده',
        ];
    }
    public function getReport()
    {
        return $this->hasOne(Report::className(),['id'=>'report_id']);
    }
    public function getUsers()
    {
        return $this->hasOne(Report::className(),['id'=>'report_id']);
    }
}
