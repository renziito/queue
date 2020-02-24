<?php

class m200224_193220_table_queu extends CDbMigration
{
    public function safeUp()
    {
		$this->createTable('queue', array(
			'id'        => 'pk auto_increment',
		));

        $this->createTable('queue', array(
            'id'        => 'pk auto_increment',
            'username'  => 'string NOT NULL',
            'register_date'  => 'datetime default NOW()',
            'nombres'   => 'string NOT NULL',
            'apellidos' => 'string NOT NULL',
            'dni'       => 'string NOT NULL',
            'correo'    => 'string',
            'rol'       => 'string NOT NULL',
            'fecha'     => 'datetime default NOW()',
            'estado'    => 'boolean default TRUE',
        ));
    }

    public function safeDown()
    {
		$this->dropTable('queue');
    }
}
