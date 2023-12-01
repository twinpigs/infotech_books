<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phone}}`.
 */
class m231201_075214_create_phone_table extends Migration
{
    private $table_name = '{{%phone}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table_name, [
            'id' => $this->primaryKey(),
            'phone' => $this->string(10)->notNull(),
        ]);

        $this->createIndex(
            'uidx-phone-phone',
            $this->table_name,
            'phone',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table_name);
    }
}
