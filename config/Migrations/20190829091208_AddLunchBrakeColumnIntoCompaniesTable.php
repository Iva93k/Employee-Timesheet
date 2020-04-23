<?php
use Migrations\AbstractMigration;

class AddLunchBrakeColumnIntoCompaniesTable extends AbstractMigration
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
        $table->addColumn('lunch_break', 'integer', [
            'after' => 'tax_number',
            'default'   => 30,
            'null'      => false
            ])
            ->update();
    }
}
