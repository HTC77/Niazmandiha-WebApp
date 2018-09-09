<?php

namespace app\controllers;
use Yii;
use app\models\Reports;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\City;
use app\models\Report;
class ReportController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','delete'],
                'rules' => [
                    [
                        'actions' => ['index','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
        if(Yii::$app->session['enum']=='admin')
            {
                $query=Reports::find();
            }
        else
            {  
                $query=Reports::findBySql('SELECT `name`, `report_id`, `ip`,`agahi_id` FROM `tbl_reports` INNER JOIN `tbl_report` ON `tbl_report`.`id`=`report_id` INNER JOIN `tbl_agahi` ON `tbl_agahi`.`id`=`agahi_id` WHERE `tbl_agahi`.`user_id`='.Yii::$app->session['user_id']);
            }
        $dataProvider=new ActiveDataProvider(['query'=>$query,'pagination'=>['pagesize'=>'15']]);
        return $this->renderAjax('index',['dataProvider'=>$dataProvider]);
    }

    public function actionSavereport()
    {
        if(Yii::$app->request->post()):
            $res=false;
            $r_id=$_POST['r_id'];
            $a_id=$_POST['a_id'];
            $ip=$_SERVER['REMOTE_ADDR'];
            if(!Reports::find()->where(['ip'=>$ip])->andWhere(['agahi_id'=>$a_id])->andWhere(['report_id'=>$r_id])->One()):
                $model=new Reports();
                $model->report_id=$r_id;
                $model->agahi_id=$a_id;
                $model->ip=$ip;
                $model->save();
                $res=true;
            endif;
            echo json_encode($res);
        endif;
    }

    public function actionDelete()
    {
        if(Yii::$app->request->post('r_id')):
            $r_id=$_POST['r_id'];
            $model=Reports::findOne($r_id);
            $res=false;
            if($model->delete()){
                $res=true;
            }
            echo json_encode($res);
        endif;
    }

    public function beforeAction($action)
    {
    	$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
    }

    public function actionGetreport() #-- Android API --#
    {
    	if(Yii::$app->request->post('get_report')):
    		$model = Report::find()->All();
    		$res = [];
    		foreach ($model as $i => $report):
    			$res[$i]['id'] = $report->id;
    			$res[$i]['onvan'] = $report->name;
    		endforeach;
    		echo json_encode($res);
    	endif;
    }

}
