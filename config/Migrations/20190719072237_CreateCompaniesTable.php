<?php
use Migrations\AbstractMigration;

class CreateCompaniesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('companies');
        
        $table->addColumn('name', 'string', [
            //'default' => null,
            'limit'     => 100,
            'null'      => false,
        ]);
        $table->addColumn('address', 'string', [
            //'default' => null,
            'limit'     => 255,
            'null'      => false,
        ]);
        $table->addColumn('city', 'string', [
            //'default' => null,
            'limit'     => 100,
            'null'      => false,
        ]);
        $table->addColumn('phone_number', 'string', [
            //'default' => null,
            'limit'     => 100,
            'null'      => false,
        ]);
        $table->addColumn('fax', 'string', [
            'default'   => null,
            'limit'     => 100,
            'null'      => true,
        ]);
        $table->addColumn('email', 'string', [
            //'default' => null,
            'limit'     => 255,
            'null'      => false,
        ]);
        $table->addColumn('web', 'string', [
            'default'   => null,
            'limit'     => 255,
            'null'      => true,
        ]);
        $table->addColumn('contact_person', 'string', [
            //'default' => null, 
            'limit'     => 255,
            'null'      => false,
        ]);
        $table->addColumn('id_number', 'string', [
            'default'   => null,
            'limit'     => 100,
            'null'      => true,
        ]);
        $table->addColumn('tax_number', 'string', [
            'default'   => null,
            'limit'     => 100,
            'null'      => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default'   => null,
            'null'      => false,
        ]);

        $table->save();

    }
}
