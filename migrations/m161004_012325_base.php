<?php

use yii\db\Migration;
use yii\db\Schema;

class m161004_012325_base extends Migration
{
    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%area}}', [
            'id' => $this->string(32)->notNull(),
            'parent_id' => $this->string(32)->notNull(),
            'name' => $this->string(128)->notNull(),
            'spell' => $this->string(128)->notNull()->defaultValue(''),
            'type' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->defaultValue(null),
            'PRIMARY KEY(id)',
            'KEY (parent_id)'
        ], $tableOptions);

        $this->createTable('{{%sequence}}', [
            'name' => $this->string(32),
            'value' => $this->integer()->notNull()->defaultValue(1),
            'version' => $this->integer()->notNull()->defaultValue(1),
            'PRIMARY KEY (name)'
        ], $tableOptions);

        $this->createTable('{{%lookup}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(32)->notNull()->comment('eg: gender'),
            'code' => $this->string(32)->notNull()->comment('eg: man | woman'),
            'value' => $this->string(64)->notNull()->comment('eg: 男 | 女'),
            'sort_order' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->defaultValue(null),
            'UNIQUE KEY (type, code)'
        ], $tableOptions);

        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'taxonomy' => $this->string(64)->notNull(),
            'code' => $this->string(64)->notNull(),
            'value' => $this->text(),
            'sort_order' => $this->integer()->notNull()->defaultValue(10),
            'serialized' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->defaultValue(null),
            'UNIQUE KEY(code)',
            'KEY (taxonomy)'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%area}}');
        $this->dropTable('{{%sequence}}');
        $this->dropTable('{{%lookup}}');
        $this->dropTable('{{%setting}}');
    }
}
