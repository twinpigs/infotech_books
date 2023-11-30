<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author_has_book}}`.
 */
class m231130_090511_create_author_has_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    private string $table_name = '{{%author_has_book}}';

    public function safeUp()
    {
        $this->createTable($this->table_name, [
            'id' => $this->primaryKey(),//не нужен, но Yii так проще
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_ahb-book_id-book-id',
            $this->table_name,
            'book_id',
            \app\models\Book::tableName(),
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_ahb-author_id-author-id',
            $this->table_name,
            'author_id',
            \app\models\Author::tableName(),
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_ahb-book_id-book-id', $this->table_name);
        $this->dropForeignKey('fk_ahb-author_id-author-id', $this->table_name);
        $this->dropTable($this->table_name);
    }
}
