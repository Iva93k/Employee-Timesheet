<?php
use Migrations\AbstractMigration;

class RenamingColumnsEmployeesTable extends AbstractMigration
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
        $table->renameColumn('date_of_birth', 'birthdate')
           ->update();
        $table->renameColumn('work_day_start', 'contract_date')
           ->update();
    }
}
