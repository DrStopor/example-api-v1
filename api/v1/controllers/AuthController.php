<?php

namespace app\api\v1\controllers;

use app\api\v1\resource\UsersResource;
use app\controllers\CustomAuthMethod;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = UsersResource::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuthMethod::class,
            'except' => ['options'],
        ];
        return $behaviors;

    }

    public function actionAuth()
    {
        // return json dummy
        return [
            'status' => 'success',
            'data' => [
                'id' => 1,
                'username' => 'admin',
                'email' => 'test@test.test'
            ]
        ];
    }

    public function actionIndex()
    {
        return [
            'status' => 'success',
            'data' => [
                'id' => 1,
                'username' => 'admin',
                'email' => 'a',
            ]
        ];
    }
}