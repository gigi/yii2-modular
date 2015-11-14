<?php

namespace modules\auth;

/**
 * Auth module
 * Register, login, logout, password restore features
 * @package modules\auth
 */
class Module extends \common\base\Module
{
    public function init()
    {
        parent::init();
        $this->layout = '/frontend/main';
    }
}