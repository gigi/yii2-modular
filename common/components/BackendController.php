<?php

namespace common\components;

use Yii;
use yii\base\Action;
use yii\helpers\Url;
use common\base\Controller;

/**
 * Class IndexController
 */
class BackendController extends Controller
{
    public $defaultController = 'index';

    public function init()
    {
        parent::init();
        $this->view->params['breadcrumbs'] = [];
    }

    /**
     * Attempt to build automatic breadcrumbs according
     * to current module, controller and action
     * @param \yii\base\Action $action
     */
    public function breadcrumbs(Action $action)
    {
        $moduleName = $this->module->id;
        $controllerName = $this->id;
        $actionName = $action->id;

        // first level for modules
        if ($actionName == $this->defaultAction && $controllerName == $this->defaultController) {
            $this->addBreadcrumb(Helper::camel2words($moduleName));
        } else {
            $this->addBreadcrumb(
                Helper::camel2words($moduleName),
                Url::to(['/' . $moduleName . '/' . $this->defaultController . '/' . $this->defaultAction])
            );
        }

        // second level for controllers
        if ($controllerName != $this->defaultController && $actionName == $this->defaultAction) {
            $this->addBreadcrumb(Helper::camel2words($controllerName));
        } elseif ($controllerName != $this->defaultController) {
            $this->addBreadcrumb(
                Helper::camel2words($controllerName),
                Url::to(['/' . $moduleName . '/' . $controllerName . '/' . $this->defaultAction])
            );
        }

        // third level for action
        if ($actionName != $this->defaultAction) {
            $this->addBreadcrumb(Helper::camel2words($actionName));
        }
    }

    /**
     * Sets current page title from action name, controller name or module name
     * Can be redefined in the view class with $this->title = ''New title'
     * @param Action $action
     */
    public function setTitle(Action $action)
    {
        if ($action->id != $this->defaultAction) {
            $title = $action->id;
        } elseif ($this->id != $this->defaultController) {
            $title = $this->id;
        } else {
            $title = $this->module->id;
        }
        $this->view->title = Helper::humanize($title);
    }

    public function beforeAction($action)
    {
        $this->breadcrumbs($action);
        $this->setTitle($action);

        return parent::beforeAction($action);
    }

    public function addBreadcrumb($label, $link = null, $options = [])
    {
        $item = [
            'label' => $label,
            'url'   => $link,
            'class' => isset($options['class']) ? $options['class'] : 'breadcrumbs__item-link'
        ];
        array_push($this->view->params['breadcrumbs'], $item);
    }
}