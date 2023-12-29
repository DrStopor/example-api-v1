<?php

namespace app\controllers;



use Yii;
use yii\rest\Controller;

class ErrorController extends Controller
{
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $response = [
                'error' => $exception->getMessage(),
                'error_key' => 'Ошибка приложения',
            ];
            if ($exception instanceof \yii\web\HttpException) {
                $response['error_key'] = $exception->statusCode;
            }
            Yii::$app->response->data = $response;
            Yii::$app->response->statusCode = 200;

            return $response;
        }

        return $this->response;
    }
}