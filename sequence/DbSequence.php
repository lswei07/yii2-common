<?php

namespace xll\common\sequence;

use yii\db\Connection;
use yii\db\Expression;
use yii\di\Instance;

/**
 *
 * DbSequence implements SequenceInterface .
 *
 * Application configuration example:
 *
 * ```
 * [
 *     'components' => [
 *         'db' => [
 *             'class' => 'yii\db\Connection',
 *             'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
 *         ]
 *         'sequence' => [
 *             'class' => 'xll\common\sequence\DbSequence',
 *              // 'db' => 'db',
 *              // 'seqTable' => 'sequence',
 *         ],
 *     ],
 * ]
 * ```
 *
 * Class DbSequence
 * @package xll\common\sequence
 */
class DbSequence extends AbstractSequence
{
    const RETRY_TIMES = 5;
    public $db = 'db';
    public $seqTable = 'sequence';

    /**
     * Initializes generic database table based mutex implementation.
     * @throws InvalidConfigException if [[db]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    public function nextValue($seqName, $step = 1)
    {
        $sql = "SELECT * FROM " . $this->seqTable . " WHERE name = :name";
        $record = $this->db->createCommand($sql, [":name" => $seqName])->queryOne();

        if (empty($record)) {
            $initialVal = 1;
            $affected = $this->insert($seqName, $initialVal);
            if ($affected) {
                return $initialVal;
            }
        }

        $affected = false;
        $retryTimes = self::RETRY_TIMES;
        while ($retryTimes && !$affected) {
            $affected = $this->update($seqName, $record['version'], $step);
            if (!$affected) {
                $retryTimes--;
            }
        }

        if (!$affected) {
            throw new \Exception("generate sequence {$seqName} id failed.");
        }
        return $record['value'] + $step;
    }

    private function insert($seqName, $initialVal = 1)
    {
        return $this->db->createCommand()
            ->insert($this->seqTable, [
                'name' => $seqName,
                'value' => $initialVal,
                'version' => 1,
            ])->execute();
    }

    private function update($seqName, $version, $step = 1)
    {
        return $this->db->createCommand()
            ->update($this->seqTable, [
                'value' => new Expression("value + {$step}")
            ], [
                'name' => $seqName,
                'version' => $version
            ])->execute();
    }
}