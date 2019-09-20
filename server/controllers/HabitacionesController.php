<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\HotelHabitacion;
use app\models\Hoteles;
use app\models\Acomodacion;
use app\models\Tipos;

/**
 * HotelesController implements the CRUD actions for Hoteles model.
 */
class HabitacionesController extends ActiveController
{
     public $modelClass = 'app\models\HotelHabitacion';

          public static function allowedDomains() {
              return [
                  // '*' allows all domains
                  'http://localhost:8000',
                  'http://test2.example.com',
              ];
          }

          /**
           * @inheritdoc
           */
           public function behaviors() {
                $behaviors =  array_merge(parent::behaviors(), [

                   // For cross-domain AJAX request
                   'corsFilter'  => [
                       'class' => \yii\filters\Cors::className(),
                       'cors'  => [
                           // restrict access to domains:
                           'Origin'                           => static::allowedDomains(),
                           'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                           'Access-Control-Allow-Credentials' => true,
                           'Access-Control-Max-Age'           => 86400,                 // Cache (seconds)
                           'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                       ],
                   ],

               ]);

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


   public function actionSearch($id)
   {

     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


     $habitacionesSearch = HotelHabitacion::Find()->where(['hotel_id' => $id])->All();



    if (empty($habitacionesSearch))
        throw new \yii\web\ServerErrorHttpException();

      $habitaciones = [];
    foreach ($habitacionesSearch as $habitacion) {

      $acomodacion = Acomodacion::Find()->where(['id' => $habitacion->acomodacion_id])->one();
      $hab = Tipos::Find()->where(['id' => $habitacion->habitacion_id])->one();

      $habitaciones[] = ['cantidad'=>$habitacion->cantidad,'id'=>$habitacion->id,'acomodacion_id'=>$habitacion->acomodacion_id,'habitacion_id'=>$habitacion->id,'acomodacion'=>$acomodacion,'habitacion'=>$hab];

    }

    return $habitaciones;




   }

   public function loadHotel($id)

    {

        $model = Hoteles::find()
            ->where(['id' => (int) $id])

            ->one();

        if (!$model) {

            throw new HttpException(404);

        }

        return $model;

    }
}
