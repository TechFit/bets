<?php

use yii\db\Migration;

class m170527_161534_userBets extends Migration
{
    public function up()
    {
        $this->createTable('userBets',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'match_id' => $this->integer()->notNull(),
            'home_team_score' => $this->integer()->notNull(),
            'guest_team_score' => $this->integer()->notNull(),
            'result' => $this->integer(),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()'
        ]);
    }

    public function down()
    {
        $this->dropTable('userBets');
    }
}
