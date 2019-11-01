<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos}}`.
 */
class m191030_162248_create_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'description' => $this->text(),
            'filepath' => $this->char(255),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey('photos_users_id_fk', '{{%photos}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photos}}');
    }
}
