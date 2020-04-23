<?php
use Migrations\AbstractMigration;

class CreateEmployeesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('employees');
        
        $table->addColumn('first_name', 'string', [
            //'default' => null,
            'limit' => 100,
            'null'  => false,
        ]);
        $table->addColumn('last_name', 'string', [
            //'default' => null,
            'limit' => 255,
            'null'  => false,
        ]);
        $table->addColumn('title', 'string', [
            //'default' => null,
            'limit' => 100,
            'null'  => false,
        ]);
        $table->addColumn('avatar', 'string', [
            'default'   => null,
            'limit'     => 255,
            'null'      => true,
        ]);
        $table->addColumn('email', 'string', [
            //'default' => null,
            'limit' => 255,
            'null'  => false,
        ]);
        $table->addColumn('phone', 'string', [
            //'default' => null,
            'limit' => 100,
            'null'  => false,
        ]);
        $table->addColumn('address', 'string', [
            //'default' => null,
            'limit' => 255,
            'null'  => false,
        ]);
        $table->addColumn('city', 'string', [
            //'default' => null,
            'limit' => 100,
            'null'  => false,
        ]);
        $table->addColumn('date_of_birth', 'date', [
            'default'   => null,
            'null'      => true,
        ]);
        $table->addColumn('work_day_start', 'date', [
            'default'   => null,
            'null'      => true,
        ]);
        $table->addColumn('uid', 'string', [
            'default'   => null,
            'null'      => true,
            'limit'     => 255,
        ]);
        $table->addColumn('allow_uid_access', 'boolean', [
            'null'      => true,
            'default'   => true,
        ]);
        $table->addColumn('status', 'boolean', [
            'null'      => false,
            'default'   => false,
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
