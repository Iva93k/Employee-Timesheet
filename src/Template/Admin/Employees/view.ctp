<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-users",
        'url'       => "/admin/employees",
        'title'     => __('List employees')
    ],
    [
        'iconClass' => false,
        'url'       => false,
        'title'     => __('View')
    ]
]) ?> 
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Employee') ?>: <?= $employee->first_name . " " . $employee->last_name ?>
                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $employee->id], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                    <?= $this->Html->link('<i class ="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Add new')]) ?>
            </header>
            <div class="panel-body">
                <table class="table  table-hover general-table">
                    <tr>
                        <th scope="row"><?= __('Photo') ?></th>
                        <td><?= $this->Html->image($employee->getPhotoFullPath(), ['width' => 50]); ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('First Name') ?></th>
                        <td><?= h($employee->first_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Last Name') ?></th>
                        <td><?= h($employee->last_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Title') ?></th>
                        <td><?= h($employee->title) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($employee->email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= h($employee->phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= h($employee->address) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($employee->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Date of birth') ?></th>
                        <td><?= date($appConfData['dateFormat'], strtotime($employee->birthdate)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Work day start') ?></th>
                        <td><?= date($appConfData['dateFormat'], strtotime($employee->contract_date)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('UID') ?></th>
                        <td><?= $employee->uid ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Allow UID access') ?></th>
                        <td><?= $employee->getUidAccessName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $employee->getStatusName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Gender') ?></th>
                        <td><?= $employee->getGenderName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($employee->created)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($employee->modified)) ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</div>

