<?php

use yii\db\Migration;

/**
 * Class m240315_102634_user
 */
class m240315_102634_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string(),
            'password' => $this->string(),
            'status' => $this->integer()->defaultValue(10),
            'auth_key' => $this->string(),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240315_102634_user cannot be reverted.\n";

        return false;
    }
    */
}
