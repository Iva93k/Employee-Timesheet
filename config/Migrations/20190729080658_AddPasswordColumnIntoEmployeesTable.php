<?php
use Migrations\AbstractMigration;

class AddPasswordColumnIntoEmployeesTable extends AbstractMigration
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
        $table->addColumn('password', 'string', ['after' => 'email'])
              ->update();
    }
}
