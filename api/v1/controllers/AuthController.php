<?php

namespace app\api\v1\controllers;

use app\api\v1\resource\UsersResource;
use app\controllers\CustomAuthMethod;
use app\helper\RequestHelper;
use app\models\Users;
use app\models\UsersSessions;
use JsonException;
use Yii;
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

    /**
     * @return array
     */
    public function actionAuth(): array
    {
        $requestBody = RequestHelper::getParams(Yii::$app->request);

        $user = UsersResource::findIdentity($requestBody['id']);
        if (!$user) {
            return [
                'status' => 'error',
                'data' => [
                    'error' => 'Пользователь не найден',
                    'error_key' => 'user not found',
                ]
            ];
        }

        $user = $this->reFillUser($user, $requestBody);

        if ($user->save()) {
            return $this->getSuccessResponse($user);
        }

        return $this->getErrorResponse($user);
    }

    /**
     * @param Users $user
     * @param array $requestBody
     * @return Users
     */
    private function reFillUser(Users $user, array $requestBody): Users
    {
        $user->first_name = $requestBody['first_name'];
        $user->last_name = $requestBody['last_name'];
        $user->city = $requestBody['city'];
        $user->country = $requestBody['country'];
        $user->usersSessions->access_token = $requestBody['access_token'];

        return $user;
    }

    /**
     * @param Users $user
     * @return array
     */
    private function getSuccessResponse(Users $user): array
    {
        return [
            'access_token' => $user->usersSessions->access_token,
            'user_info' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'city' => $user->city,
                'country' => $user->country,
            ],
            'error' => '',
            'error_key' => '',
        ];
    }

    private function getErrorResponse(Users $user)
    {
        try {
            return [
                'error' => json_decode((string)$user->getFirstErrors(), true, 512, JSON_THROW_ON_ERROR),
                'error_key' => '500',
            ];
        } catch (JsonException $e) {
            return [
                'error' => $e->getMessage(),
                'error_key' => '500',
            ];
        }
    }
}