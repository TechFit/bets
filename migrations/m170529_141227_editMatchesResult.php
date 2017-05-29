<?php

use yii\db\Migration;

class m170529_141227_editMatchesResult extends Migration
{
    public function up()
    {
        $this->alterColumn('matches', 'home_team_result', $this->string()->defaultValue('-'));
        $this->alterColumn('matches', 'guest_team_result', $this->string()->defaultValue('-'));
    }

    public function down()
    {
        $this->alterColumn('matches', 'home_team_result', $this->integer());
        $this->alterColumn('matches', 'guest_team_result', $this->integer());
    }
}
