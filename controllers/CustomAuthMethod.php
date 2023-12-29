<?php

namespace app\controllers;

use app\models\Users;
use app\models\UsersSessions;
use app\helper\RequestHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;

/**
 * Class CustomAuthMethod
 * @package app\controllers
 */
class CustomAuthMethod extends AuthMethod
{
    private array $params = [];

    /**
     * @inheritDoc
     */
    public function authenticate($user, $request, $response)
    {
        $this->params = RequestHelper::getParams($request);
        if (!$this->validateParams()) {
            return null;
        }

        if (!isset($this->params['sig']) || empty($this->params['sig'])) {
            return null;
        }
        $sig = $this->params['sig'];
        unset($this->params['sig']);

        ksort($this->params);
        $str = $this->prepareStringParams();
        $hash = md5($str);
        /**
         * Если будут переданы дополнительные параметры, то сравнение будет не корректным
         */
        if (!$this->isEqualSig($hash, $sig)) {
            return null;
        }

        $userAuth = $this->getUser();
        if (!$userAuth) {
            $userAuth = $this->createUser();
        }
        if ($userAuth !== null) {
            $userSession = $userAuth->usersSessions;
            if (!$userSession) {
                return null;
            }
            // TODO реализация переносится в контроллер AuthController
            /*if (!$this->isEqualAccessToken($userSession->access_token, $this->params['access_token'])) {
                $this->updateAccessToken($userSession);
            }*/
        }

        return $userAuth;
    }

    /**
     * @return bool
     */
    private function validateParams(): bool
    {
        $requiredParams = ['id', 'first_name', 'last_name', 'city', 'country', 'access_token'];
        foreach ($requiredParams as $param) {
            if (!isset($this->params[$param]) || empty($this->params[$param])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    private function prepareStringParams(): string
    {
        $str = '';

        array_walk($this->params, static function ($value, $key) use (&$str) {
            $str .= "$key=$value";
        });
        $str .= Yii::$app->params['secretKey'];
        return $str;
    }

    /**
     * @param string $hash
     * @param string $sig
     * @return bool
     */
    private function isEqualSig(string $hash, string $sig): bool
    {
        return mb_strtolower($hash, 'UTF-8') === mb_strtolower($sig, 'UTF-8');
    }

    /**
     * @return IdentityInterface|null|ActiveRecord
     */
    private function getUser()
    {
        // TODO реализация с приоритетом поиск по access_token
        /*$user = Users::findIdentityByAccessToken($this->params['access_token']);

        if (!$user) {
            $user = Users::find()
                ->where(['id' => $this->params['id']])
                ->limit(1)
                ->one();
        }

        if ($user !== null && $user->id !== (int)$this->params['id']) {
            $user = null;
        }*/

        return Users::find()
            ->where(['id' => $this->params['id']])
            ->limit(1)
            ->one();
    }

    /**
     * @param UsersSessions $userSession
     * @return void
     */
    private function updateAccessToken(UsersSessions $userSession): void
    {
        $userSession->access_token = $this->params['access_token'];
        $userSession->save();
    }

    /**
     * @return Users
     */
    private function createUser(): Users
    {
        $user = new Users();
        $user->first_name = $this->params['first_name'];
        $user->last_name = $this->params['last_name'];
        $user->city = $this->params['city'];
        $user->country = $this->params['country'];
        $user->id = (int)$this->params['id'];

        if ($user->save()) {

            $userSession = new UsersSessions();
            $userSession->user_id = $user->id;
            $userSession->access_token = $this->params['access_token'];
            $userSession->save();
        }
        return $user;
    }

    /**
     * @param string $accessToken
     * @param string $paramAccessToken
     * @return bool
     */
    private function isEqualAccessToken(string $accessToken, string $paramAccessToken): bool
    {
        return mb_strtolower($accessToken, 'UTF-8') === mb_strtolower($paramAccessToken, 'UTF-8');
    }

    /**
     * {@inheritdoc}
     */
    public function handleFailure($response): Response
    {
        $response->data = [
            'error' => 'Ошибка авторизации',
            'error_key' => 401,
        ];

        $response->statusCode = 200;

        return $response;
    }
}