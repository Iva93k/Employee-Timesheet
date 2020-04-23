<?php
use Migrations\AbstractMigration;

class AddCompanyWorkingPeriod extends AbstractMigration
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
        $table = $this->table('companies');
        $table->addColumn('start_working_time', 'time', ['after' => 'tax_number'])
              ->update();
        $table->addColumn('end_working_time', 'time', ['after' => 'start_working_time'])
              ->update();
    }
}
