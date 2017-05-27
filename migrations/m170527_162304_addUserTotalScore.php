<?php

use yii\db\Migration;

class m170527_162304_addUserTotalScore extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'totalScore', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('user', 'totalScore');
    }

}