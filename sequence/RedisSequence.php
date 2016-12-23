<?php

namespace xll\common\sequence;

use yii\di\Instance;
use yii\redis\Connection;

/**
 * To use redis Sequence as the secquence application component, configure the application as follows,
 *
 * ~~~
 * [
 *     'components' => [
 *         'sequence' => [
 *             'class' => 'xll\common\sequence\RedisSequence',
 *             'redis' => [
 *                 'hostname' => 'localhost',
 *                 'port' => 6379,
 *                 'database' => 0,
 *             ]
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * Or if you have configured the redis [[Connection]] as an application component, the following is sufficient:
 *
 * ~~~
 * [
 *     'components' => [
 *         'sequence' => [
 *             'class' => 'xll\common\sequence\RedisSequence',
 *             // 'redis' => 'redis' // id of the connection application component
 *         ],
 *     ],
 * ]
 * ~~~
 * Class RedisSequence
 * @package xll\common\sequence
 */
class RedisSequence extends AbstractSequence
{
    public $redis = 'redis';

    /**
     * Initializes the redis Cache component.
     * This method will initialize the [[redis]] property to make sure it refers to a valid redis connection.
     * @throws InvalidConfigException if [[redis]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->redis = Instance::ensure($this->redis, Connection::className());
    }

    public function nextValue($seqName, $step = 1)
    {
        return $this->redis->executeCommand('INCRBY', [$seqName, $step]);
    }
}