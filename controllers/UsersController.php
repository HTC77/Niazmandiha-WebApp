<?php

namespace app\controllers;
use Yii;
use app\models\Users;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Agahi;
use app\models\Reports;
class UsersController extends \yii\web\Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','changepassword','updateprofile','create','view','update','delete','assignpassword'],
                'rules' => [
                    [
                        'actions' => ['index','changepassword','updateprofile','create','view','update','delete','assignpassword'],
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
    public function actionChangepassword()
    {
        $session=Yii::$app->session;
        if(!Yii::$app->request->post() && $session->has('model')):
            $model=new Users();
            $model->setScenario('changepwd');
            $model=$session['model'];
            $model->validate();
            $session->remove('model');
            $model->new_password = '';
            $model->confirm_password = '';
            return $this->renderAjax('changepassword',['model'=>$model]);
        else:
            $id=$session['user_id'];
            $model=new Users();
            $model->setScenario('changepwd');	
    		if($model->load(Yii::$app->request->post())):
             if($model->validate()):
    	        $model->password=Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
    	        Users::updateAll(['password'=>$model->password],'id='.$id);
    	        Yii::$app->user->logout();
    	        $session->remove('user_id','enum');
    	        return $this->redirect(Yii::$app->homeUrl.'site/login');
             else:
                $session['model']=$model;
                return $this->redirect(Yii::$app->homeUrl.'admin/index');
             endif;
    	    endif;
    	    $model->new_password = '';
    	    $model->confirm_password = '';
    	    return $this->renderAjax('changepassword',['model'=>$model]);
        endif;    
    }
    public function actionUpdateprofile()
    {
        $session=Yii::$app->session;
        if(!Yii::$app->request->post() && $session->has('model')):
            $model=new Users();
            $model->setScenario('profile');
            $model=$session['model'];
            $model->validate();
            $session->remove('model');
            return $this->renderAjax('updateprofile',['model'=>$model]);
        else:
            $id=Yii::$app->user->identity->id;
            $model=Users::findOne($id);
            $model->setScenario('profile');
            if($model->load(Yii::$app->request->post())):
                if($model->validate()):
                    $model->update();
                    $session->remove('pagination_url');
                    return $this->redirect(Yii::$app->homeUrl.'admin/index');
                else:
                    $session['model']=$model;
                    return $this->redirect(Yii::$app->homeUrl.'admin/index');
                endif;
            endif;
            return $this->renderAjax('updateprofile',['model'=>$model]);
        endif;    
    }
    public function actionCreate()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $session=Yii::$app->session;
            $model=new Users();
            $model->setScenario('create');
            if($session->has('model')):
                $model=$session['model'];
                $model->validate();
                $session->remove('model');
                $model->password='';
                $model->confirm_password='';
            elseif($model->load(Yii::$app->request->post())):
                    if($model->validate()):
                        $model->password=Yii::$app->getSecurity()->generatePasswordHash($model->password);
                        $model->save(false);
                        return $this->redirect(Yii::$app->homeUrl.'admin/index');
                    else:
                        $session['model']=$model;
                        return $this->redirect(Yii::$app->homeUrl.'admin/index');
                    endif; 
            endif;
            return $this->renderAjax('create',['model'=>$model]);
        endif;
    }
    public function actionView()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $query=Users::find();
            $dataProvider=new ActiveDataProvider(['query'=>$query,'pagination'=>['pagesize'=>'15']]);
            return $this->renderAjax('view',['dataProvider'=>$dataProvider]);
        endif;
    }
    public function actionUpdate()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $session=Yii::$app->session;
            if(Yii::$app->request->post('u_id')):
                $id=$_POST['u_id'];
                $session['uid']=$id;
                $model=Users::findOne($id);
                $model->setScenario('update');
                return $this->renderAjax('update', ['model' => $model]);
            endif;

            $id=$session['uid'];
            $model=Users::findOne($id);
            $model->setScenario('update');
            if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
                echo json_encode(ActiveForm::validate($model)) ;
            elseif ($model->load(Yii::$app->request->post())):
                if($model->validate()){
                    $model->update();
                    $session->remove('uid');
                    return $this->redirect(Yii::$app->homeUrl.'admin/index');
                }
            endif;
        endif;
    }
    public function actionDelete()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            if(Yii::$app->request->post()):
                $id=$_POST['u_id'];
                $amodel=new Agahi();
                $amodel=$amodel->find()->where(['user_id'=>$id])->All();
                foreach ($amodel as $model){
                    Reports::deleteAll('agahi_id='.$model->id);
                }
                Agahi::deleteAll('user_id='.$id);
                Users::deleteAll('id='.$id);
            endif;
        endif;
    }
    public function actionAssignpassword()
    {   if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $session=Yii::$app->session;
            $model=new Users();
            $model->setScenario('newpwd');
            if(Yii::$app->request->post('u_id')):            
                return $this->renderAjax('newpassword',['model'=>$model,'id'=>$_POST['u_id']]);      
            elseif(Yii::$app->request->post()):
                $id=$_POST['uid'];
                $model=$model->findOne($id);
                $model->setScenario('newpwd');
                $model->load(Yii::$app->request->post());
                $model->password=Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
                $model->update();
                if ($id==Yii::$app->user->identity->id):
                    Yii::$app->user->logout();
                    $session->remove('user_id','enum');
                    return $this->redirect(Yii::$app->homeUrl.'site/login');
                endif;
            endif;
        endif;
    }
}
