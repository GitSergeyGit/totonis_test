<?php

use yii\db\Migration;

/**
 * Class m210204_185246_create_user_address
 */
class m210204_185246_create_user_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'postcode' => $this->integer()->notNull(),
            'country' => $this->string(2)->notNull(),
            'city' => $this->string()->notNull(),
            'street' => $this->string()->notNull(),
            'house_number' => $this->string()->notNull()->defaultValue(0),
            'apartment' => $this->string()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('user_address-user_id','user_address','user_id');

        $this->addForeignKey(
            'fk-user_address-user_id',
            'user_address',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_address}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210204_185246_create_user_address cannot be reverted.\n";

        return false;
    }
    */
}
