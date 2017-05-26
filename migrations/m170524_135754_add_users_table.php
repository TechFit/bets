<?php

use yii\db\Migration;

class m170524_135754_add_users_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'password' => $this->text()->notNull(),
            'role' => $this->string()->defaultValue('user'),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
