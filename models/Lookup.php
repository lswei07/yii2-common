<?php

namespace xll\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $type
 * @property string $code
 * @property string $value
 * @property integer $sort_order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 */
class Lookup extends \yii\db\ActiveRecord
{
    private static $_items = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lookup';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'code', 'value'], 'required'],
            [['sort_order', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type', 'code'], 'string', 'max' => 32],
            [['value'], 'string', 'max' => 64],
            [['type', 'code'], 'unique', 'targetAttribute' => ['type', 'code'], 'message' => 'The combination of Type and Code has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'code' => 'Code',
            'value' => 'Value',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public static function items($type)
    {
        if (!isset(self::$_items[$type])) {
            self::loadItems($type);
        }
        return self::$_items[$type];
    }

    public static function item($type, $code)
    {
        if (!isset(self::$_items[$type])) {
            self::loadItems($type);
        }
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : null;
    }

    private static function loadItems($type)
    {
        self::$_items[$type] = [];
        $models = static::find()
            ->where("type = :type", [":type" => $type])
            ->orderBy('sort_order')
            ->all();
        foreach ($models AS $model) {
            self::$_items[$type][$model->code] = $model->value;
        }
    }
}
