<?php

namespace common\components;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Menu extends Component
{
    /**
     * Menu holder
     * @var array
     */
    private $menu = [];

    /**
     * Add items for provided key
     * Each item should be a flat array
     *
     * @see yii\widgets\Menu for accepted items array
     *
     * @param string $key
     * @param array $items
     */
    public function add($key, array $items)
    {
        $this->menu[$key] = ArrayHelper::merge($this->get($key), $items);
    }

    /**
     * Returns menu array
     *
     * @param null $key
     * @return array
     */
    public function get($key = null)
    {
        if (!empty($key)) {
            if (isset($this->menu[$key])) {
                return $this->menu[$key];
            } else {
                return [];
            }
        }

        return $this->menu;
    }
}