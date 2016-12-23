<?php

namespace tests\unit\models;

use xll\common\sequence\DbSequence;
use xll\common\sequence\RedisSequence;
use Yii;
class SequenceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        /*$name = "item";
        $i = 10;
        while($i) {
            $val = Yii::$app->sequence->nextValue($name);
            error_log($val);
            $i--;
        }*/
    }

    public function testDb() {
        $sequence = new DbSequence();
        $name = "item";
        //$this->nextValue($sequence, $name, 10);
    }

    public function testRedis() {
        $sequence = new RedisSequence();
        $name = "item";
        //$this->nextValue($sequence, $name, 10);
    }

    private function nextValue($sequence, $name, $times, $step) {
        while($times) {
            $val = $sequence->nextValue($name, $step);
            error_log($val);
            $times--;
        }
    }
}