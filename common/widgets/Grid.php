<?php

namespace common\widgets;

use yii\helpers\Html;

class Grid extends \yii\grid\GridView
{
    /**
     * @var array of buttons to be placed in caption section
     */
    public $headerButtons;

    public function renderCaption()
    {
        $content = '';

        if (!empty($this->caption)) {
            $content .= Html::tag('span', $this->caption, [
                'class' => 'page__content-title'
            ]);
        }

        if (!empty($this->headerButtons)) {
            if (is_array($this->headerButtons)) {
                foreach($this->headerButtons as $key => $button) {
                    if (is_string($key)) {
                        $content .= $this->renderButton([$key => $button]);
                    } else {
                        $content .=  $this->renderButton($button);
                    }
                }
            } else {
                $content .= $this->renderButton($this->headerButtons);
            }
        }

        if (!empty($content)) {
            return Html::tag('caption', $content, $this->captionOptions);
        }

        return false;
    }

    /**
     * Renders buttons by key or by instance
     *
     * @param $button
     * @return string
     */
    public function renderButton($button)
    {
        if (is_array($button)) {
            $name = key($button);
            $url = $button[$name];

            if ($name === 'create') {
                return Html::a('<i class="icon icon-plus"></i> Create', $url, [
                    'class' => 'btn btn-sm btn-success table-caption-button page__content-header-btn',
                ]);
            }
        }

        return (string)$button;
    }
}