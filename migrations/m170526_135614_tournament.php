<?php

use yii\db\Migration;

class m170526_135614_tournament extends Migration
{
    public function up()
    {
        $this->createTable('tournament', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'tournament_img' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('tournament');
    }
}
