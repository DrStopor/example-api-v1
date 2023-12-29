<?php

namespace app\api\v1;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // get controller and action
        //var_dump(\Yii::$app);die();
        parent::init();
        // custom initialization code goes here
    }

    public function beforeAction($action)
    {
        /*\Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;*/
        return parent::beforeAction($action);
    }
}
