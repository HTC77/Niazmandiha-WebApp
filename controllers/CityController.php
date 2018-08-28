<?php

namespace app\controllers;
use Yii;
use app\models\Mahale;
use app\models\City;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\models\Agahi;
use app\models\Reports;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class CityController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','delete','create','createmahale','view','update','delete','mahaleview','mahaleupdate','mahaledelete'],
                'rules' => [
                    [
                        'actions' => ['index','delete','create','createmahale','view','update','delete','mahaleview','mahaleupdate','mahaledelete'],
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
        return $this->render('index');
    }
    public function actionGetmahale()
    {
    	if(Yii::$app->request->post('city'))
    	{
    		$mahale=Mahale::find()->where(['city_id'=>$_POST['city']])->All();
    		$res=[];
    		$i=0;
    		foreach ($mahale as $mahale):
    			$res[$i]['id']=$mahale->id;
    			$res[$i]['name']=$mahale->name;
    			++$i;
    		endforeach;
    		echo json_encode($res);		
    	}
    	else
    	{
    		return $this->redirect(Yii::$app->homeUrl);
    	}
    }
    public function actionCreate()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $model = new City();

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
                echo json_encode(ActiveForm::validate($model));
            elseif(Yii::$app->request->post()):
                $model->load(Yii::$app->request->post());
                    $model->save();
                    return $this->redirect(Yii::$app->homeUrl.'admin/index');
            else:
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            endif;       
        endif; 
    }
    public function actionCreatemahale()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $model = new Mahale();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
                echo json_encode(ActiveForm::validate($model));
            elseif ($model->load(Yii::$app->request->post())) :
                $model->save();
                return $this->redirect(Yii::$app->homeUrl.'admin/index');
            else:
                $cookie=Yii::$app->request->cookies;
                $getCity=City::find()->where(['latin_name'=>$cookie['city']])->One();
                $city_id=$getCity->id;
                $city=City::find()->All();
                $city=ArrayHelper::map($city,'id','persian_name');
                return $this->renderAjax('createmahale', [
                    'model' => $model,'city'=>$city,'city_id'=>$city_id
                ]);
            endif;
        endif;
    }
    public function actionView()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
            else:
            $query=City::find();
            $dataProvider=new ActiveDataProvider(['query'=>$query,'pagination'=>['pageSize'=>'15']]);
            return $this->renderAjax('view',['dataProvider'=>$dataProvider]);
        endif;
    }
    public function actionUpdate()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:   
            $model = new City();
            $session=Yii::$app->session;
            if(!Yii::$app->request->post()) $session->remove('model');
            if($session->has('model')) $model=$session['model'];
            
            if(Yii::$app->request->post('c_id')):
                $id=$_POST['c_id'];
                $model =City::findOne($id);
                $session['model']=$model;
                return $this->renderAjax('update', [
                    'model' => $model
                ]);
            elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
                echo json_encode(ActiveForm::validate($model));
            elseif(Yii::$app->request->post()):
                $model=$session['model'];
                $model->load(Yii::$app->request->post());
                    $model->update();
                    return $this->redirect(Yii::$app->homeUrl.'admin/index');
            endif;
        endif;
    }
    public function actionDelete()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            if(Yii::$app->request->post()):
                $id=$_POST['c_id'];
                $amodel=new Agahi();
                $amodel=$amodel->find()->where(['city_id'=>$id])->All();
                foreach ($amodel as $model)
                    Reports::deleteAll('agahi_id='.$model->id);
                Agahi::deleteAll('city_id='.$id);
                Mahale::deleteAll('city_id='.$id);
                City::deleteAll('id='.$id);
            endif;
        endif;
    }

    //mahale
    public function actionSession()
    {
        if(Yii::$app->request->post('c_id')):
            Yii::$app->session['c_id']=$_POST['c_id'];
		elseif(Yii::$app->request->post('submit')):
		    Yii::$app->session['submit']=$_POST['submit'];
        endif;
    }
    public function actionMahaleview()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $query= Mahale::find()->where(['city_id'=>Yii::$app->session['c_id']]);
            $dataProvider=new ActiveDataProvider(['query'=>$query,'pagination'=>['pageSize'=>'8']]);
            return $this->renderAjax('viewmahale',['dataProvider'=>$dataProvider]);
        endif;
    }
    public function actionMahaleupdate()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $model = new Mahale();
            $session=Yii::$app->session;
            if($session->has('model')) $model=$session['model'];
            
            if(Yii::$app->request->post('m_id')):
                $id=$_POST['m_id'];
                $model =Mahale::findOne($id);
                $session['model']=$model;
                return $this->renderAjax('updatemahale', ['model' => $model,'pgu'=>$_POST['pgu'],'m_pgu'=>$_POST['m_pgu']]);
            elseif (!$session->has('submit') && Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
                echo json_encode(ActiveForm::validate($model));
            elseif(Yii::$app->request->post()):
                $model->load(Yii::$app->request->post());
                $model->update();
                $session->remove('submit');
            endif;
        endif;
    }
    public function actionMahaledelete()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            if(Yii::$app->request->post()):
                $id=$_POST['m_id'];
                $amodel=new Agahi();
                $amodel=$amodel->find()->where(['mahale_id'=>$id])->All();
                foreach ($amodel as $model)
                    Reports::deleteAll('agahi_id='.$model->id);
                Agahi::deleteAll('mahale_id='.$id);
                Mahale::deleteAll('id='.$id);
            endif;
        endif;
    }
}
