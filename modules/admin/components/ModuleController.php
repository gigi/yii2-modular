<?php

namespace modules\admin\components;

use common\base\Controller;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * Class IndexController
 * @package app\modules\site\controllers
 */
class ModuleController extends Controller
{
    public $defaultController = 'index';

    public function init()
    {
        parent::init();
        $this->view->params['breadcrumbs'] = [];
    }

    public function beforeAction($action)
    {
        if ($action->id != $this->defaultAction) {
            if ($this->id != $this->defaultController) {
                $this->addBreadcrumb(Inflector::camel2words($this->id), Url::to([$this->id . '/' . $this->defaultController]));
            }
            $this->addBreadcrumb(Inflector::camel2words($action->id));
        } elseif ($this->id != $this->defaultController) {
            $this->addBreadcrumb(Inflector::camel2words($this->id));
        }

        return parent::beforeAction($action);
    }

    public function addBreadcrumb($label, $link = null)
    {
        $item = [
            'label' => $label,
            'url'   => $link,
            'class' => 'breadcrumbs__item-link'
        ];
        array_push($this->view->params['breadcrumbs'], $item);
    }
}