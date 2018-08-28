<?php

/* @var $this yii\web\View */
use app\models\Category;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use hoomanMirghasemi\jdf\Jdf;
$this->title = 'نیازمندی های آنلاین';
$url=Yii::$app->homeUrl;
?>
<main>  
  <div class="row"> <!-- ROW -->
    <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 pull-right"> <!-- COLUMN 1 -->
      <aside>
      <div class="r-side">

        <section class="categories"> <!-- SECTION 1 -->
          <div class="title"><h3><span class=" glyphicon glyphicon-th-list"></span>&nbsp;دسته ها</h3></div>
          <div class="body">
            <div class="agahi-items">
              <div class="btn-back" style="display:none;"><img src=<?=$url.'img/right.png'?> width="50" height="50"></div>
              <ul id='categories'>
                <li id="parent_0"><a href="#">همه دسته ها</a></li>
                <?php
                 $cat=Category::find()->where(['parent'=>'y'])->All();
                 foreach ($cat as $cat):?>
                 <li id=<?='parent_'.$cat->id?>><a href="#"><?=$cat->onvan?></a></li>
                <?php endforeach?>
              </ul>
            </div>
          </div>
        </section>  <!-- SECTION 1 -->      

        <section class="most-popular"> <!-- SECTION 2 -->
          <div class="title"><h3><span class="glyphicon glyphicon-heart"></span><span id="text">پر بازدید ترین آگهی ها</span></h3></div>
          <div class="row text-center body">
          <?php foreach ($best_post as $i=> $row): ?>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="card">
                <a target="_blank" href="site/details/id/<?=$row->id?>"><img class="card-img-top" src="<?=$row->pic=='no'?$url.'img/nopic.png':$url.'uploads/'.explode('|',$row->pic)[0]?>" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title"><?=$row->onvan?></h4>
                  <div align="right" class="card-text">
                    <strong>شهر: </strong><?=$row->city->persian_name?><br>
                    <strong>محله: </strong><?=$row->mahale->name?><br>
                    <strong>تاریخ: </strong><?=$row->tarikh?><br>
                    <strong>قیمت: </strong>
                    <span style="color: orange"><?php
                      try {
                        number_format($row->price);
                        echo $row->price.'  تومان';
                      } catch (Exception $e) {
                        echo $row->price;
                      }?> 
                    </span>
                  </div>
                </div>
                <div class="card-footer">
                  <a target="_blank" href="site/details/id/<?=$row->id?>" class="btn btn-primary btn-sm">جزئیات آگهی</a>
                </div>
              </div>
            </div>
            <?php if ($i==1): ?>
              <div style="clear: both;"></div>
            <?php endif ?>
          <?php endforeach ?>
          </div>
        </section><!-- SECTION 2 -->
      </div>  
      </aside>
    </div><!-- COLUMN 1 -->
      
    <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 pull-left"> <!-- COLUMN 2 -->
      <div class="main">

        <section> <!-- SECTION 1 -->
          <div class="search">
            <div class="title"><h3><span class="glyphicon glyphicon-search"></span>&nbsp;جستجو</h3></div>  
            <div class="body">
              <?php $form=ActiveForm::begin(['id'=>'search-form','method'=>'post']);?>
                <?=$form->field($search,'txt').'<br>';?>
                <?=$form->field($search,'mahale')->dropdownlist($mahale,['prompt'=>'محله مورد نظر خود را انتخاب کنید']).'<br>';?>
                <?=$form->field($search,'picture')->checkbox();?> 
                <?='<div align="left">'.Html::submitButton('جستجو',['class'=>'btn btn-primary']).'</div>';?>
              <?php ActiveForm::end();?>  
            </div>
          </div>
        </section> <!-- SECTION 1 -->

        <section><!-- SECTION 2 -->
          <div class="agahiha">
            <div class="row">
              <?php if($post!=null):
              foreach($post as $row):?>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <article>
                <div class="agahi-item">
                  <div class="agahi-details">
                    <div class="onvan" id="row_agahi-<?=$row->id;?>">
                    <p><?=$row->onvan?></p>
                    </div>
                    <div class="pic">
                      <a target="_blank" href="site/details/id/<?=$row->id?>">
                      <img width="100%" height="100%" src="<?=$row->pic=='no'?$url.'img/nopic.png':$url.'uploads/'.explode('|',$row->pic)[0]?>"></a>
                    </div>
                    <div class="mahale"><strong><?=$row->mahale->name?></strong></div>
                    <div class="date"><?=$row->tarikh?></div>
                  </div>
                  <div class="price">
                    <span>قیمت: 
                      <?php
                        try {
                          number_format($row->price);
                          echo $row->price.'  تومان';
                        } catch (Exception $e) {
                          echo $row->price;
                        }
                      ?> 
                    </span>
                  </div>
                </div>
              </article>
              </div>
              <?php endforeach;endif;?> 
            </div>
          </div>         
        </section><!-- SECTION 2 -->

      </div><!--main -->
    </div><!-- COLUMN 2 --> 
  </div><!-- ROW -->
</main>