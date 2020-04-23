<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-users",
        'url'       => "/admin/administrators",
        'title'     => __('List administrators')
    ],
    [
        'iconClass' => false,
        'url'       => false,
        'title'     => __('Profile')
    ]
]) ?>
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Administrator') ?>: <?= $administrator->first_name . " " . $administrator->last_name ?>
                <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $administrator->id], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?> 
            </header>
        <div class="panel-body">
            <table class="table  table-hover general-table">
                <tr>
                    <th scope="row"><?= __('First Name') ?></th>
                    <td><?= h($administrator->first_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Name') ?></th>
                    <td><?= h($administrator->last_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Email') ?></th>
                    <td><?= h($administrator->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Role') ?></th>
                    <td><?= $administrator->getRoleName() ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?= $administrator->getStatusName() ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Created') ?></th>
                    <td><?= date($appConfData['dateTimeFormat'], strtotime($administrator->created)) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Modified') ?></th>
                    <td><?= date($appConfData['dateTimeFormat'], strtotime($administrator->modified)) ?></td>
                </tr>
            </table>
        </div>
        </section>
    </div>
</div>
