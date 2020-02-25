<?php

class m200224_193220_table_queu extends CDbMigration {

    public function safeUp() {
        $this->createTable('queue', array(
            'id' => 'pk auto_increment',
            'username' => 'string NOT NULL',
            'queue_start' => 'datetime default NOW()',
            'queue_finish' => 'datetime',
            'state' => 'boolean default TRUE'
        ));

        $this->createTable('queue_list', array(
            'id' => 'pk auto_increment',
            'order' => 'int NOT NULL',
            'queue_id' => 'int NOT NULL',
            'username' => 'string NOT NULL',
            'args' => 'string',
            'play' => 'boolean default FALSE',
            'remove' => 'boolean default FALSE',
            'register_date' => 'datetime default NOW()',
            'state' => 'boolean default TRUE'
        ));
    }

    public function safeDown() {
        $this->dropTable('queue');
        $this->dropTable('queue_list');
    }

}
