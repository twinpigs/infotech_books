<?php

use app\models\Author;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m231201_081322_create_subscription_table extends Migration
{
    private $table_name = '{{%subscription}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table_name, [
            'id' => $this->primaryKey(),
            'phone_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'scheduled' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        $this->createIndex(
            'uidx-subscription-phone_id-author_id',
            $this->table_name,
            ['phone_id', 'author_id'],
            true
        );
        $this->createIndex(
            'uidx-subscription-scheduled',
            $this->table_name,
            'scheduled',
        );
        $this->addForeignKey(
            'fk-subscription-phone_id-phone-id',
            $this->table_name,
            'phone_id',
            '{{%phone}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-subscription-author_id-author-id',
            $this->table_name,
            'author_id',
            Author::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscription-phone_id-phone-id', $this->table_name);
        $this->dropForeignKey('fk-subscription-author_id-author-id', $this->table_name);
        $this->dropTable($this->table_name);
    }
}
