<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
/**
 * HotelesController implements the CRUD actions for Hoteles model.
 */
class TiposHotelesController extends ActiveController
{
     public $modelClass = 'app\models\TiposHoteles';

     public function behaviors()
 {
     $behaviors = parent::behaviors();
     $behaviors['authenticator'] = [
         'class' => CompositeAuth::className(),
         'authMethods' => [
             HttpBasicAuth::className(),
             HttpBearerAuth::className(),
             QueryParamAuth::className(),
         ],
     ];
     return $behaviors;
 }

}
