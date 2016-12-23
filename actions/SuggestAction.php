<?php

namespace xll\common\actions;

use yii\base\Action;
use yii\helpers\Json;

class SuggestAction extends Action
{
    /**
     * @var string name of the model class.
     */
    public $modelName;
    /**
     * @var string name of the method of model class that returns data.
     */
    public $methodName;
    /**
     * @var integer maximum number of rows to be returned
     */
    public $limit = 20;

    /**
     * Suggests models based on the current user input.
     */
    public function run()
    {
        if (isset($_GET['term']) && ($keyword = trim($_GET['term'])) !== '') {
            $model = new $this->modelName;
            $suggest = $model->{$this->methodName}($keyword, $this->limit, $_GET);

            echo Json::encode($suggest);
        }
    }
} 