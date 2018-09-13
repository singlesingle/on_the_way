<?php

namespace app\modules\page;

/**
 *  * modules module definition class
 *   */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\page\controllers';
    public function init()
    {   
        parent::init();
        $this->setViewPath('@app/views');
        $this->layout = false;
    }
}

