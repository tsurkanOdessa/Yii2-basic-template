<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200128_134147_add_table_pages
 */
class m200128_134147_add_table_pages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->down();
        } catch (Exception $e) {

        }

        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // table blog_catalog
        $this->createTable(
            '{{%pages}}',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'name' => Schema::TYPE_STRING . '(32) NOT NULL',
                'sort_order' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 50',
                'title' => Schema::TYPE_STRING . '(32) NOT NULL',
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('parent_id', '{{%pages}}', 'parent_id');
        $this->createIndex('sort_order', '{{%pages}}', 'sort_order');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200128_134147_add_table_pages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200128_134147_add_table_pages cannot be reverted.\n";

        return false;
    }
    */
}
