<?php

namespace xll\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "area".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $spell
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 */
class Area extends \yii\db\ActiveRecord
{
    const TYPE_PROVINCE = 1;
    const TYPE_CITY = 2;
    const TYPE_DISTRICT = 3;
    const TYPE_TOWN = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
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
            [['id', 'parent_id', 'name'], 'required'],
            [['type', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['id', 'parent_id'], 'string', 'max' => 32],
            [['name', 'spell'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'spell' => 'Spell',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
