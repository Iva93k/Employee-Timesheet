<?php
use Migrations\AbstractMigration;

class CreateAdministratorsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('administrators');
 
        $table->addColumn('first_name', 'string', [
            //'default' => null,
            'limit'     => 100,
            'null'      => false,
        ]);
        $table->addColumn('last_name', 'string', [
            //'default' => null,
            'limit'     => 100,
            'null'      => false,
        ]);
        $table->addColumn('password', 'string', [
            //'default' => null,
            'limit'     => 255,
            'null'      => false,
        ]);
        $table->addColumn('password_reset_token', 'string', [
            'default'   => null,
            'limit'     => 255,
            'null'      => true,
        ]);
        $table->addColumn('email', 'string', [
            //'default' => null,
            'limit'     => 255,
            'null'      => false,
        ]);
        $table->addColumn('role', 'integer', [
            'default'   => 1,
            'limit'     => 6,
            'null'      => false,
        ]);
        $table->addColumn('status', 'boolean', [
            'default'   => false,
            'null'      => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);

        $table->save();
    }
}
