<?php
use Migrations\AbstractMigration;

class CreateWorkDayLogsTable extends AbstractMigration
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
        $table = $this->table('work_day_logs');
        
        $table->addColumn('work_day', 'date', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('check_in_time', 'time', [
            'default' => '00:00',
            'null'  => false,
        ]);
        $table->addColumn('check_out_time', 'time', [
            'default' => '00:00',
            'null'  => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('employee_id', 'integer', [
            //'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('work_day_type_id', 'integer', [
            //'default'   => null,
            'null'      => false,
        ]);

        $table->save();
    }
}
