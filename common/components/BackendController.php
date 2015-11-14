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
     * Sets current page title using Action
     * if $action is string then sets current $action param directly to view instance
     * Can be redefined in the view class with $this->title = 'New title'
     * @param \yii\base\Action|string $action
     */
    public function setTitle($action)
    {
        if ($action instanceof Action) {
            // auto title
            if ($action->id != $this->defaultAction) {
                $title = $action->id;
            } elseif ($this->id != $this->defaultController) {
                $title = $this->id;
            } else {
                $title = $this->module->id;
            }
            $title = Helper::humanize($title);
        } else {
            $title = $action;
        }

        $this->view->title = $title;
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