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
        'title'     => __('View')
    ]
]) ?> 
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Administrator') ?>: <?= $administrator->first_name . " " . $administrator->last_name ?>
                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $administrator->id], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?>
                    <?php if($administrator['id'] != $authUserData['id']): ?> 
                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $administrator->id], ['confirm' => __('Are you sure you want to delete # {0}?', $administrator->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                    <?php endif; ?>
                    <?= $this->Html->link('<i class ="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Add new')]) ?>
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
