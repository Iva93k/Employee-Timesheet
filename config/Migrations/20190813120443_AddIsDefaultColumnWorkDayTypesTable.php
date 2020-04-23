<?php
use Migrations\AbstractMigration;

class AddIsDefaultColumnWorkDayTypesTable extends AbstractMigration
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
        $table = $this->table('work_day_types');
        $table->addColumn('is_default', 'boolean', ['after' => 'check_in_enabled'])
              ->update();
    }
}
