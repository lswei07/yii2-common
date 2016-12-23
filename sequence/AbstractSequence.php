<?php

namespace xll\common\sequence;

use yii\base\Component;

abstract class AbstractSequence extends Component implements SequenceInterface
{
    abstract public function nextValue($seqName, $step = 1);
}