<?php

namespace app\controllers;
use Yii;
use app\models\Agahi;
use app\models\City;
use yii\web\Cookie;
use app\models\Mahale;
use app\models\Category;
use yii\helpers\ArrayHelper;
use hoomanMirghasemi\jdf\Jdf;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Reports;
class AgahiController extends \yii\web\Controller
{   
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['Create','saveagahi','view','details','delete','update','updateagahi','changetaeed','setting','session'],
                'rules' => [
                    [
                        'actions' => ['Create','saveagahi','view','details','delete','update','updateagahi','changetaeed','setting','session'],
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
	public function beforeAction($action)
    {
    	$this->enableCsrfValidation=false;
    	return parent::beforeAction($action);
    }
    public function actionGetwithchild()
    {
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
    	if(Yii::$app->request->post('get_with_child')):
            $post=Agahi::findBySql('SELECT * FROM `tbl_agahi` WHERE `cat_id`='.$_POST['ch_id'].' AND `city_id`='.$city->id.' AND `taeed`=1 ORDER BY `id` DESC LIMIT '.$_POST['lim'].',8 ')->All();
    		$res=[];
    		$i=0;
    		foreach ($post as $post):
    			$res[$i]['id']=$post->id;
    			$res[$i]['onvan']=$post->onvan;
    			$res[$i]['pic']=$post->pic;
    			$res[$i]['tarikh']=$post->tarikh;
                $res[$i]['price']=$post->price;
                $res[$i]['mahale']=$post->mahale->name;
    			$i++;
    		endforeach;
    		echo json_encode($res);
    	else:
    		return $this->redirect(Yii::$app->homeUrl);
 		endif;
    }

    public function actionGet()
    {
        if(isset($_POST['cityId'])):
            $cityId = $_POST['cityId']; # -- Android -- #
        else:
            $cookie=Yii::$app->request->cookies;
            $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
            $cityId = $city->id;
        endif;
        if(Yii::$app->request->post('get_agahi')):
            $post=Agahi::findBySql('SELECT * FROM `tbl_agahi` WHERE `city_id`='.$cityId.' AND `taeed`=1 ORDER BY `id` DESC LIMIT '.$_POST['lim'].',8')->All();
            $res=[];
            $i=0;
            foreach ($post as $post):
                $res[$i]['id']=$post->id;
                $res[$i]['onvan']=$post->onvan;
                $res[$i]['pic']=$post->pic;
                $res[$i]['tarikh']=$post->tarikh;
                $res[$i]['price']=$post->price;
                $res[$i]['mahale']=$post->mahale->name;
                $i++;
            endforeach;
            echo json_encode($res);
        else:
            return $this->redirect(Yii::$app->homeUrl);
        endif;  
    }

    public function actionGetwithsearch()
    {
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
        if(Yii::$app->request->post('get_with_search')):
            $txt=$_POST['text'];
            $mahale=$_POST['m_id'];
            $picture=$_POST['pic'];
            $sql='';

            //LIKE `onvan`
            if($txt==''):$sql.="SELECT * FROM `tbl_agahi` WHERE `taeed`=1 AND `city_id`='".$city->id."' "; else: $sql.="SELECT * FROM `tbl_agahi` WHERE `onvan` LIKE '%".$_POST['text']."%' AND `taeed`=1 AND `city_id`='".$city->id."' ";endif;
            if($_POST['pic']=='true'):
             $sql.=" AND `pic` !='no'";
            endif;
            if($mahale==''):$sql.=" UNION ";else:$sql.=" AND `mahale_id`='".$_POST['m_id']."' UNION ";endif;

            //UNION LIKE `tozihat`
            if($txt==''):$sql.="SELECT * FROM `tbl_agahi` WHERE `taeed`=1 AND `city_id`='".$city->id."' "; else: $sql.="SELECT * FROM `tbl_agahi` WHERE `tozihat` LIKE '%".$_POST['text']."%' AND `taeed`=1 AND `city_id`='".$city->id."' ";endif;
            if($_POST['pic']=='true'):
             $sql.=" AND `pic` !='no'";
            endif;
            if($mahale==''):$sql.=" ORDER BY `id` DESC LIMIT ".$_POST['lim'].",8";else:$sql.=" AND `mahale_id`='".$_POST['m_id']."' ORDER BY `id` DESC LIMIT ".$_POST['lim'].",8";endif;
            


            $post=Agahi::findBySql($sql)->All();
            $res=[];
            $i=0;
            foreach ($post as $post):
                $res[$i]['id']=$post->id;
                $res[$i]['onvan']=$post->onvan;
                $res[$i]['pic']=$post->pic;
                $res[$i]['tarikh']=$post->tarikh;
                $res[$i]['price']=$post->price;
                $res[$i]['mahale']=$post->mahale->name;
                $i++;
            endforeach;
            echo json_encode($res);
        endif;
    }

    public function actionCreate()
    {
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
        $model = new Agahi();
        $mahale=Mahale::find()->where(['city_id'=>$city->id])->All();
        $mahale=ArrayHelper::map($mahale,'id','name');
        $cat=Category::find()->where(['parent'=>'y'])->All();
        $cat=ArrayHelper::map($cat,'id','onvan');
        return $this->renderAjax('create', ['model' => $model,'mahale'=>$mahale,'cat'=>$cat,'city'=>$city]);
    }

    private function savepic()
    {   
        $pic_name='';
        $root=$_SERVER['DOCUMENT_ROOT'];
        $pics=explode(',',$_POST['pic_file']);
        $ext=explode(',',$_POST['pic_ext']);
        foreach ($pics as $i => $pic):
        if($pic!=null):    
            $fileName=md5(time().$i);
            $file=fopen($root.'/web/uploads/'.$fileName.$ext[$i],'w+');
            fwrite($file,base64_decode($pic));
            fclose($file);
            $pic_name.="$fileName$ext[$i]|";
        endif;
        endforeach;
        $pic_name=$pic_name=='' ? 'no' : substr($pic_name, 0,-1);
        return $pic_name;       
    }

    public function actionSaveagahi()
    {   
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
        $model=new Agahi();
        if($model->load(Yii::$app->request->post())):
           $pic=$_POST['pic_file'];
           $model->pic=$pic==null?"no":$this->savepic();
           $model->cat_id=$model->subCat_id;
           $model->user_id=Yii::$app->session['user_id'];
           $model->tarikh=Jdf::jdate('Y/m/d');
           $model->city_id=(string)$city->id;
           //$model->price = preg_replace('/[^0-9]/', '', $model->price);
           $model->save();
           return $this->redirect(Yii::$app->homeUrl.'admin/index');
           // print_r(\yii\bootstrap\ActiveForm::validate($model));
        endif;
    }


    public function actionView()
    {
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
        $query='';
        if(Yii::$app->session['enum']=='admin')
            {
                $query=Agahi::find()->where(['city_id'=>$city->id]);
            }
        else
            {
                $query=Agahi::find()->where(['user_id'=>Yii::$app->session['user_id']])->andWhere(['city_id'=>$city->id])->with('user');
            }
        $dataProvider=new ActiveDataProvider(['query'=>$query,'pagination'=>['pagesize'=>'15']]);
        return $this->renderAjax('view',['dataProvider'=>$dataProvider]);

    }

    public function actionDetails()
    {   
        if(Yii::$app->request->post()):
            $model=Agahi::find()->with('user','cat','mahale','city')->where(['id'=>$_POST['a_id']])->One();
            $parent=Category::find()->where(['id'=>$model->cat->parent])->One();
           
            return $this->renderAjax('details',['model'=>$model,'parent'=>$parent]);
        endif;
    }

    public function actionDelete()
    {
        if(Yii::$app->request->post()):
            $id=$_POST['a_id'];
            $model=new Agahi();
            $model->deleteAll('id='.$id); 
            Reports::deleteAll('agahi_id='.$id);
        endif;
    }

    public function actionUpdate()
    {   
        if(Yii::$app->request->post()):
            $id=$_POST['a_id'];
            else:return $this->redirect(Yii::$app->homeUrl);
        endif;
        $cookie=Yii::$app->request->cookies;
        $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();   
        $model=Agahi::find()->with('cat')->where(['id'=>$id])->One();
        $mahale=Mahale::find()->where(['city_id'=>$city->id])->All();
        $city=City::find()->All();
        $city=ArrayHelper::map($city,'id','persian_name');
        $mahale=ArrayHelper::map($mahale,'id','name');
        $cat=Category::find()->where(['parent'=>'y'])->All();
        $cat=ArrayHelper::map($cat,'id','onvan');
        $subcat=$model->subCat_id=$model->cat_id;
        $parent=$model->cat_id=$model->cat->parent;
        $subcats=Category::find()->where(['parent'=>$parent])->all();
        $subcats=ArrayHelper::map($subcats,'id','onvan');
        return $this->renderAjax('update', ['model' => $model,'mahale'=>$mahale,'cat'=>$cat,'subcats'=>$subcats,'city'=>$city]);
    }

    private function updatepic($pic)
    {   
        $pic_name='';
        $root=$_SERVER['DOCUMENT_ROOT'];
        $pics=explode(',',$_POST['pic_file']);
        $ext=explode(',',$_POST['pic_ext']);
        $pic=explode('|', $pic);
        $changed=explode(',',$_POST['changed_pics']);
        for ($i=1; $i <= 4; $i++):
            $j=$i-1;
            $path=$i<=count($pic)?$root.'/web/uploads/'.$pic[$j]:'';
            if($changed[$i]==0 && $i<=count($pic)):    
                if(file_exists($path))unlink($path);
                $pic[$j]=null;
            elseif($changed[$i]==1):
                if(file_exists($path))unlink($path);
                $fileName=md5(time().$i);
                $file=fopen($root.'/web/uploads/'.$fileName.$ext[$i],'w+');
                fwrite($file,base64_decode($pics[$i]));
                fclose($file);
                $pic[$j]="$fileName$ext[$i]";
            endif;      
        endfor;
        $pics=$pic;
        foreach ($pics as $i => $pic):
            if($pic!=null) $pic_name.="$pic|";
        endforeach;
        $pic_name=$pic_name=='' ? 'no' : substr($pic_name, 0,-1);
        return $pic_name;       
    }

    public function actionUpdateagahi()
    {   
        if(Yii::$app->request->post()):
            $id=$_POST['a_id'];
            $model=new Agahi();
            $model=$model->findOne($id);
            else:return $this->redirect(Yii::$app->homeUrl);
        endif;
        if($model->load(Yii::$app->request->post())):
            $pic_name=$_POST['pic_file'];
            if($pic_name!=null)$model->pic=$model->pic=='no'?$this->savepic():$this->updatepic($model->pic);
            $model->cat_id=$model->subCat_id;
            //$model->price = preg_replace('/[^0-9]/', '', $model->price);
            $model->update();
            return $this->redirect(Yii::$app->homeUrl.'admin/index');
        endif;
    }
    public function actionChangetaeed()
    {
        if(Yii::$app->request->post()):
            $id=$_POST['a_id'];
            $state=$_POST['a_state'];
            $res=false;
            Agahi::updateAll(['taeed'=>$state],'id='.$id)?$res=true:$res=false;
            echo json_encode($res);
        endif;
    }
    public function actionSetting(){
        if(Yii::$app->request->post('city')):
            $cookie=Yii::$app->response->cookies;
            unset($cookie['city']);
            $cookie->add(new yii\web\Cookie(['name'=>'city','value'=>$_POST['city'],'expire'=>time()+86400*30]));
            return $this->redirect(Yii::$app->homeUrl.'admin/index');
        endif;
        $cookie=Yii::$app->request->cookies;
        $getCity=City::find()->where(['latin_name'=>$cookie['city']])->One();
        $city_id=$getCity->id;  
        $city=City::find()->All();
        return $this->renderAjax('setting',['city'=>$city,'city_id'=>$city_id]);       
    }
    public function actionSession(){
        if(Yii::$app->request->post()):
            $session=Yii::$app->session;
            $action=$_POST['action'];
            if(isset($_POST['pg'])) $page=$_POST['pg'];
            $action=='create' ? $session['pagination_url']=$page : $session->remove('pagination_url','c_id','model');
        endif;
    }

    public function actionGetdetails() # -- Android API -- #
    {
    	if(Yii::$app->request->post('get_details')):
    		$id = $_POST['a_id'];
    		$detail = Agahi::find()->where(['id' => $id])->One();
            $parent=Category::find()->where(['id'=> $detail->cat->parent])->One();
    		$res['id'] = $detail->id;
    		$res['onvan'] = $detail->onvan;
    		$res['tozihat'] = $detail->tozihat;
    		$res['tarikh'] = $detail->tarikh;
    		$res['pic'] = $detail->pic;
    		$res['cat'] = $parent->onvan.'>'.$detail->cat->onvan;
    		$res['city'] = $detail->city->persian_name;
    		$res['mahale'] = $detail->mahale->name;
    		$res['price'] = $detail->price;
    		$res['userName'] = $detail->user->name.' '.$detail->user->family;
    		$res['tel'] = $detail->user->tel;
    		$res['email'] = $detail->user->email;
    		echo json_encode($res);
    	endif;
    }
}

