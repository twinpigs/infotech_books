<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m231130_085513_create_author_table extends Migration
{
    private string $table_name = '{{%author}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table_name, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex('idx-author-name', $this->table_name, 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table_name);
    }
}
