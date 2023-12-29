<?php

namespace app\controllers;



use yii\rest\Controller;

class ErrorController extends Controller
{

    private $response = [
        'error' => "Ошибка",
        'error_key' => 'signature error',
    ];

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $response = [
                'error' => $exception->getMessage(),
                'error_key' => 'Ошибка приложения',
            ];
            if ($exception instanceof \yii\web\HttpException) {
                $response['error_key'] = $exception->statusCode;
            }
            \Yii::$app->response->data = $response;

            return $response;
        }

        return $this->response;
    }
}