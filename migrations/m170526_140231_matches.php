<?php

use yii\db\Migration;

class m170526_140231_matches extends Migration
{
    public function up()
    {
        $this->createTable('matches', [
            'id' => $this->primaryKey(),
            'home_team_id' => $this->integer(),
            'guest_team_id' => $this->integer(),
            'start_time' => $this->dateTime(),
            'end_time' => $this->dateTime(),
            'home_team_result' => $this->integer(),
            'guest_team_result' => $this->integer(),
            'won_team_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('matches');
    }
}
