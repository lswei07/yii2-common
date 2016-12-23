<?php

namespace xll\common\sequence;

interface SequenceInterface
{
    public function nextValue($seqName, $step = 1);
}