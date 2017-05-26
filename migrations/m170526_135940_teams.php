<?php

use yii\db\Migration;

class m170526_135940_teams extends Migration
{
    public function up()
    {
        $this->createTable('Teams', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'tournament_id' => $this->integer(),
            'team_img' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('Teams');
    }
}
