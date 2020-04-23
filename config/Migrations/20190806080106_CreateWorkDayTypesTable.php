<?php
use Migrations\AbstractMigration;

class CreateWorkDayTypesTable extends AbstractMigration
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
        
        $table->addColumn('code', 'string', [
            //'default' => null,
            'limit' => 1,
            'null'  => false,
        ]);
        $table->addColumn('title', 'string', [
            //'default' => null,
            'limit' => 100,
            'null'  => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            //'null'  => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('check_in_enabled', 'boolean', [
            'null'      => true,
            'default'   => true,
        ]);

        $table->save();
    }
}
