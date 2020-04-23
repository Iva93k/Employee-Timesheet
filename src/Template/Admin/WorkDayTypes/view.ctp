<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-check-square-o",
        'url'       => "/admin/WorkDayTypes",
        'title'     => __('List work day types')
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
                <?= __('Work day type') ?>: <?= $workDayType->code . " - " . $workDayType->title ?>
                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $workDayType->id], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $workDayType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workDayType->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                    <?= $this->Html->link('<i class ="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Add new')]) ?>
            </header>
            <div class="panel-body">
                <table class="table  table-hover general-table">
                    <tr>
                        <th scope="row"><?= __('Code') ?></th>
                        <td><?= h($workDayType->code) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Title') ?></th>
                        <td><?= h($workDayType->title) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td><?= h($workDayType->description) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($workDayType->created)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($workDayType->modified)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Check-in enabled') ?></th>
                        <td><?= $workDayType->getCheckInStatusName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Default') ?></th>
                        <td><?= $workDayType->getIsDefaultStatusName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Weekend') ?></th>
                        <td><?= $workDayType->getIsWeekendStatusName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Payed') ?></th>
                        <td><?= $workDayType->getPayedStatusName() ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Color') ?></th>
                        <?php $style = 'color: ' . $workDayType->color . ';' ; ?>
                        <td>
                            <i class="fa fa-circle" style="<?= $style ?>"></i>
                            <?= h($workDayType->color) ?>    
                        </td>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</div>
