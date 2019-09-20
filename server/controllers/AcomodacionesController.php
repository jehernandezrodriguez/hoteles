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
class AcomadacionesController extends ActiveController
{
     public $modelClass = 'app\models\Acomodacion';

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
                          'Access-Control-Request-Method'    => ['POST','PUT','DELETE'],
                          'Access-Control-Allow-Credentials' => true,
                          'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
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

}
