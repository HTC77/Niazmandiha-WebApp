<?php
namespace app\models;
use yii\base\Model;
use Yii;
/**
* author HTC
*/
class Search extends Model
{
	public $txt;
	public $mahale;
	public $picture;
	public function attributeLabels()
	{
		return 	[
				'txt'=>'متن جستجو:',
				'mahale'=>'محله:',
				'picture'=>'عکس دار'
				];
	}
}

?>