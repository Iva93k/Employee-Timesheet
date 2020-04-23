<?php
use Migrations\AbstractMigration;

class AddAutoLoggedColumnIntoWorkDayLogsTable extends AbstractMigration
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
        $table->addColumn('auto_logged', 'boolean', [
            'after'     => 'check_out_time',
            'default'   => false,
            'null'      => false
            ])
            ->update();
    }
}
