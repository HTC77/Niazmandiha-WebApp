<?php

namespace app\controllers;
use Yii;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Agahi;
use app\models\Reports;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class CategoryController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','edit','delete'],
                'rules' => [
                    [
                        'actions' => ['create','edit','delete'],
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
    public function actionGetchild()
    {
    	if(Yii::$app->request->post('get_child'))
    	{
    		$cat=Category::find()->where(['parent'=>$_POST['p_id']])->All();
    		$res=[];
    		$i=0;
    		foreach ($cat as $cat):
    			$res[$i]['id']=$cat->id;
    			$res[$i]['onvan']=$cat->onvan;
    			++$i;
    		endforeach;
    		echo json_encode($res);		
    	}
    	else
    	{
    		return $this->redirect(Yii::$app->homeUrl);
    	}

    }

    public function actionGetparent()
    {
        if(Yii::$app->request->post('get_parent'))
        {
            $cat=Category::find()->where(['parent'=>'y'])->All();
            $res=[];
            $i=0;
            foreach($cat as $cat):
                $res[$i]['id']=$cat->id;
                $res[$i]['onvan']=$cat->onvan;
                $i++;
            endforeach;
            echo json_encode($res);
        }
        else
        {
            return $this->redirect(Yii::$app->homeUrl);
        }

    }
    public function actionGet(){
        if(Yii::$app->request->post('c_id')){
            $cat=Category::find()->where(['id'=>$_POST['c_id']])->One();
            $res=$cat->tozihat;
            echo json_encode($res);
        }
    }
    public function actionCreate()
    {   
        if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $model=new Category();
            if(Yii::$app->request->post('c_parent')):
                $model->setScenario('cat');
                $model->load(Yii::$app->request->post());
                if(Yii::$app->request->isAjax):
                    echo json_encode(ActiveForm::validate($model));
                else:
                    $model->parent='y';
                    $model->save();
                endif;
            elseif(Yii::$app->request->post('c_child')):
                $model->setScenario('child');
                $model->load(Yii::$app->request->post());
                if(Yii::$app->request->isAjax):
                    echo json_encode(ActiveForm::validate($model));
                else:
                    $model->save();
                endif;
            else:
                $cat=new Category();
                $cat=$cat->find()->where(['parent'=>'y'])->All();
                $cat=ArrayHelper::map($cat,'id','onvan');
                return $this->renderAjax('create',['model'=>$model,'cat'=>$cat]);
            endif;
        endif;
    }
    public function actionEdit()
    {   
        if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
            $model=new Category();
            if(Yii::$app->request->post('cat_id')):
                $model=$model->findOne($_POST['cat_id']);
                $model->setScenario('cat');
                $model->load(Yii::$app->request->post());
                if(Yii::$app->request->isAjax):
                    echo json_encode(ActiveForm::validate($model));
                else:
                    $model->parent='y';
                    $model->update();
                endif;
            elseif(Yii::$app->request->post('ch_id')):
                $model=$model->findOne($_POST['ch_id']);
                $model->setScenario('child');
                $model->load(Yii::$app->request->post());
                if(Yii::$app->request->isAjax):
                    echo json_encode(ActiveForm::validate($model));
                else:
                    $model->update();
                endif;
            else:
                $cat=new Category();
                $cat=$cat->find()->where(['parent'=>'y'])->All();
                $cat=ArrayHelper::map($cat,'id','onvan');
                $model=new Category();
                return $this->renderAjax('edit',['model'=>$model,'cat'=>$cat]);
            endif;
        endif;
    }
    public function actionDelete()
    {   
        if(Yii::$app->session['enum']!='admin'):
            $this->redirect(Yii::$app->homeUrl.'admin/index');
        else:
        	if(Yii::$app->request->post('cat')):
        		$cat=$_POST['cat'];
        		$id=$_POST['c_id'];
        		if($cat=='child'):
        			$agahi=Agahi::find()->Where(['cat_id'=>$id])->All();
                    foreach ($agahi as $agahi)
                        Reports::deleteAll('agahi_id='.$agahi->id);
                    Agahi::deleteAll('cat_id='.$id);
                    Category::deleteAll('id='.$id);
        		elseif($cat=='parent'):
                    $child=Category::find()->where(['parent'=>$id])->All();
                    foreach ($child as $child) {
                        $agahi=Agahi::find()->Where(['cat_id'=>$child->id])->All();
                        foreach ($agahi as $agahi)
                            Reports::deleteAll('agahi_id='.$agahi->id);
                        Agahi::deleteAll('cat_id='.$child->id);
                        Category::deleteAll('id='.$child->id);
                    }
                    Category::deleteAll('id='.$id);
        		endif;
        	endif;
        endif;
    }
}
