<?php

/**
 * Created by PhpStorm.
 * User: ProsoftPC
 * Date: 11/10/2016
 * Time: 10:16 AM
 */
namespace common\components;

use \yii\web\Request as BaseRequest;

class Request extends BaseRequest
{
    public $web;
    public $adminUrl;

    public function getBaseUrl()
    {
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->adminUrl;
    }

    public function resolvePathInfo()
    {
        if ($this->getUrl() === $this->adminUrl) {
            return "";
        } else {
            return parent::resolvePathInfo();
        }
    }
}