<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-suitcase",
        'url'       => false,
        'title'     => __('Company')
    ]
]) ?> 
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Company') ?>: <?= $company->name ?>
                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit'], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?>
            </header>
            <div class="panel-body">
                <table class="table  table-hover general-table">
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($company->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= h($company->address) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($company->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone number') ?></th>
                        <td><?= h($company->phone_number) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Fax') ?></th>
                        <td><?= h($company->fax) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($company->email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Web') ?></th>
                        <td><?= h($company->web) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact person') ?></th>
                        <td><?= h($company->contact_person) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('ID number') ?></th>
                        <td><?= h($company->id_number) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('TAX number') ?></th>
                        <td><?= h($company->tax_number) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Lunch break') ?></th>
                        <td><?= $company->lunch_break . ' min' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Working time') ?></th>
                        <td><?= date($appConfData['timeFormat'], strtotime($company->start_working_time)) . ' - ' . date($appConfData['timeFormat'], strtotime($company->end_working_time))?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($company->created)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($company->modified)) ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</div>