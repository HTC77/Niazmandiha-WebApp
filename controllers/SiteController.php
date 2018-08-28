<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\City;
use yii\web\Cookie;
use app\models\Category;
use app\models\Agahi;
use app\models\Search;
use yii\helpers\ArrayHelper;
use app\models\Mahale;
use app\models\Users;
use app\models\Report;
use yii\widgets\ActiveForm;
use app\models\Site;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCities()
    {
        if(Yii::$app->request->post('city')):
            $cookie=Yii::$app->response->cookies;
            unset($cookie['city']);
            $cookie->add(new yii\web\Cookie(['name'=>'city','value'=>$_POST['city'],'expire'=>time()+86400*30]));
        else:
            $res;
            $cookie=Yii::$app->request->cookies;
            $getCity=City::find()->where(['latin_name'=>$cookie['city']])->One();
            $city_id=$getCity->id;  
            $city=City::find()->All();
            foreach ($city as $i => $city) {
               $res[$i]['latin_name']=$city->latin_name;
               $res[$i]['persian_name']=$city->persian_name;
            }
            $res[count($res)]['latin_name']=$cookie['city'];
            $res[count($res)]['persian_name']=$getCity->persian_name;
            $city=$res;
            echo json_encode($city);        
        endif;
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {    
        $cookie=Yii::$app->request->cookies;
        $cookieManager=Yii::$app->response->cookies;
        if(Yii::$app->request->get('city'))
        {
            if($cookie->has('city'))
            {    
                $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$cookie['city']->value.'"')->One();
                $post=Agahi::findBySql('SELECT * FROM `tbl_agahi` WHERE `city_id`='.$city->id.' AND `taeed`=1 ORDER BY `id` DESC LIMIT 8')->All();
                $best_post=Agahi::findBySql('SELECT * FROM `tbl_agahi` WHERE `taeed`=1 ORDER BY `visit` DESC LIMIT 4')->All();
                $search=new Search();
                $mahale=Mahale::find()->where(['city_id'=>$city->id])->All();
                $mahale=ArrayHelper::map($mahale,'id','name');
                return $this->render('index',['post'=>$post,'search'=>$search,'mahale'=>$mahale,'best_post'=>$best_post]);
            }
            else
            {   $city=City::findBySql('SELECT `id` FROM `tbl_city` WHERE `latin_name`="'.$_GET['city'].'"')->One();
                if($city!=null){
                    $cookieManager->add(new Cookie(['name'=>'city','value'=>$_GET['city'],'expire'=>time()+86400*30]));
                }
                return $this->redirect(Yii::$app->homeUrl);
            }
        }
        else
        {
            if($cookie->has('city'))
            {
                return $this->redirect(Yii::$app->homeUrl.$cookie['city']->value);
            }
            else
            {
                return $this->redirect(Yii::$app->homeUrl.'site/city'); 
            }
        }
    }

    public function actionCity()
    {
        $city=City::find()->All();
        return $this->render('city',['city'=>$city]);
    }


    public function actionRegister()
    {   
        $model=new Users();
        $model->setScenario('register');
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        elseif(Yii::$app->request->post()):
            $model->load(Yii::$app->request->post());
            $model->password=Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->save(false);
                return $this->redirect(Yii::$app->homeUrl);
        else:
             return $this->render('register',['model'=>$model]); 
        endif;   
    }

    public function actionDetails()
    {
        if(Yii::$app->request->get('id')):
            $id=$_GET['id'];
            if(Agahi::findOne($id)):
                $report=Report::find()->All();
                $model=new Agahi();
                $model=$model->findOne($id);
                $model->updateAll(['visit'=>$model->visit+1],'id='.$id);
                return $this->render('details',['model'=>$model,'report'=>$report]);
            else:
                return $this->redirect(Yii::$app->homeUrl);
            endif;
        else:
            return $this->redirect(Yii::$app->homeUrl);
        endif;
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();   
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        unset(Yii::$app->session['user_id']);
        unset(Yii::$app->session['enum']);
        return $this->goHome();
    }

    public function actionAbout()
    {
        $root=$_SERVER['DOCUMENT_ROOT'];
        if(!$model=Site::findOne(1)) :
            $model=new Site(); 
            $model->save();
            $model=Site::findOne(1);
        endif;
        $html=$model->about;
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('img');
        if($model->load(Yii::$app->request->post())):
            $model->update();
            $newHtml=$model->about;
            foreach ($tags as $tag) {
               $pic = $tag->getAttribute('src');
               if (strpos($newHtml, $pic) == false) {
                    $pic=str_replace('http://localhost',$root,$pic);
                    if(file_exists($pic)) unlink($pic);
                }
            }
        endif;
        $html=$model->about;
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('img');
        $dir = "$root/web/uploads/froala_images";
        $keepFiles = array();
        foreach ($tags as $tag) {
            $pic = $tag->getAttribute('src');
            $pic=str_replace('http://localhost/web/uploads/froala_images/','',$pic);
            array_push($keepFiles,$pic);
        }
        foreach(glob("$dir/*") as $file ) {
            if( !in_array(basename($file), $keepFiles) )
                unlink($file);
        }
        return $this->render('about',['model'=>$model]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}
