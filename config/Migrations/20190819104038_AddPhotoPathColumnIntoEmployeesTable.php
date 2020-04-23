<?php
use Migrations\AbstractMigration;

class AddPhotoPathColumnIntoEmployeesTable extends AbstractMigration
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
        $table->addColumn('photo_path', 'string', [
            'after' => 'photo_name',
            'default'   => null,
            'limit'     => 255,
            'null'      => true
            ])
            ->update();
    }
}
