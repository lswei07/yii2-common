<?php

namespace xll\common\actions;

use yii\base\Action;

class AjaxEchoAction extends Action
{

    /**
     * @var string name of the model class.
     */
    public $modelClazz;

    /**
     * @var
     */
    public $attributeName;

    /**
     * Suggests models based on the current user input.
     */
    public function run()
    {
        if (isset($_GET['id'])) {
            $model = new $this->modelClazz;
            $model = $model->findOne($_GET['id']);
            echo $model->{$this->attributeName};
        }
    }
} 