<?php

namespace app\helper;

use yii\base\InvalidConfigException;
use yii\web\Request;

class RequestHelper
{
    /**
     * @param Request $request
     * @return array
     */
    public static function getParams(Request $request)
    {
        try {
            $bodyParams = $request->getBodyParams();
        } catch (InvalidConfigException $e) {
            $bodyParams = [];
        }
        $queryParams = $request->getQueryParams();

        return array_merge($bodyParams, $queryParams);
    }
}