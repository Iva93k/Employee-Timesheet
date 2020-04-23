<?php
use Migrations\AbstractMigration;

class RenamingaColumnEmployeesTable extends AbstractMigration
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
        $table->renameColumn('avatar', 'photo_name')
           ->update();
    }
}
