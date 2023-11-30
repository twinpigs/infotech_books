<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m231130_085926_create_book_table extends Migration
{
    private string $table_name = '{{%book}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table_name, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(13)->notNull(),
            'cover' => $this->string(),
        ]);

        $this->createIndex('idx-book-title', $this->table_name, 'title');
        $this->createIndex('idx-book-year', $this->table_name, 'year');
        $this->createIndex('uidx-book-isbn', $this->table_name, 'isbn', true);
        $this->createIndex('uidx-book-cover', $this->table_name, 'cover', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-book-title', $this->table_name);
        $this->dropIndex('idx-book-year', $this->table_name);
        $this->dropIndex('uidx-book-isbn', $this->table_name);
        $this->dropIndex('uidx-book-cover', $this->table_name);
        $this->dropTable($this->table_name);
    }
}
