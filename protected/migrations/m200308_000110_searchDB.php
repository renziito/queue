<?php

class m200308_000110_searchDB extends CDbMigration {

    public function safeUp() {
        $this->createTable('event', array(
            'id' => 'pk auto_increment',
            'type' => 'string NOT NULL',
            'username' => 'string',
            'text' => 'string',
            'gift' => 'boolean default FALSE',
            'receiver' => 'string',
            'amount' => 'int',
            'register_event' => 'datetime default NOW()',
            'state' => 'boolean default TRUE'
        ));
    }

    public function safeDown() {
        $this->dropTable('event');
    }

}
