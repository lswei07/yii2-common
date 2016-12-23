<?php

namespace xll\common\grid;

class EnumColumn extends \yii\grid\DataColumn
{
    public $enum = [];

    public function init()
    {
        $this->filter = $this->enum;
    }

    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        return \yii\helpers\ArrayHelper::getValue($this->enum, $value, $value);
    }
}