<?php


namespace xll\common\traits;


trait SoftDeleteTrait
{
    protected $forceDelete = false;

    public static $softDelete = true;
    public static $softDeleteAttribute = 'timeDeleted';

    /**
     * Returns newly created ActiveQuery instance
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        $query = parent::find();

        if (static::$softDelete) {
            $query->andWhere(['timeDeleted' => null]);
        }

        return $query;
    }

    /**
     * Before delete action
     * @return bool
     */
    public function beforeDelete()
    {
        // Do nothing if safe mode is disabled. This will result in a normal deletion
        if (!static::$softDelete) {
            return parent::beforeDelete();
        }

        // Remove and return false to prevent real deletion
        else {
            $this->remove();
            return false;
        }
    }

    /**
     * Remove (aka soft-delete) record
     */
    public function remove()
    {
        // Evaluate timestamp and set attribute
        $timestamp = date('Y:m:d H:i:s');
        $attribute = static::$softDeleteAttribute;
        $this->$attribute = $timestamp;

        // Save record
        $this->save(false, [$attribute]);

        // Trigger after delete
        $this->afterDelete();
    }

    /**
     * Restore soft-deleted record
     */
    public function restore()
    {
        // Mark attribute as null
        $attribute = static::$softDeleteAttribute;
        $this->$attribute = null;

        // Save record
        $this->save(false, [$attribute]);
    }

    /**
     * Delete record from database regardless of the $softDelete attribute
     */
    public function forceDelete()
    {
        $softDelete = static::$softDelete;
        static::$softDelete = false;
        $this->delete();
        static::$softDelete = $softDelete;
    }

    public function getDeletedAtColumn() {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }
}