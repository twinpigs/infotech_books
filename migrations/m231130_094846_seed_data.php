<?php


use yii\db\Migration;

/**
 * Class m231130_094846_seed_data
 */
class m231130_094846_seed_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/data/seed.sql');
        $command = $this->db->createCommand($sql);
        $command->execute();
        while ($command->pdoStatement->nextRowSet()) {}

        $book_ids = \app\models\Book::find()->select('id')->column();
        $author_ids = \app\models\Author::find()->select('id')->column();

        foreach ($book_ids as $book_id) {
            $author_num = rand(1, 3);
            for ($author_index = 0; $author_index < $author_num; $author_index++) {
                $author_id = $author_ids[rand(0, count($author_ids) - 1)];
                $this->insert(
                    'author_has_book',
                    [
                        'book_id' => $book_id,
                        'author_id' => $author_id,
                    ],
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(\app\models\Book::tableName());
        $this->delete(\app\models\Author::tableName());
    }
}
