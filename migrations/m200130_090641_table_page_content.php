<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200130_090641_table_page_content
 */
class m200130_090641_table_page_content extends Migration
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
            '{{%page_content}}',
            [
                'id' => Schema::TYPE_PK,
                'page_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'content' => Schema::TYPE_TEXT ,
            ],
            $tableOptions
        );
        // Indexes
        $this->createIndex('page_id', '{{%page_content}}', 'page_id');



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200130_090641_table_page_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200130_090641_table_page_content cannot be reverted.\n";

        return false;
    }
    */
}
