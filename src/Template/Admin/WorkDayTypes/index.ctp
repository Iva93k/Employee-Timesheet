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
    ]
]);
?>
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Work day types') ?>
                <div class="indexActionButtons pull-right">
                    <?= $this->Html->link('<i class ="fa fa-plus"> ' . __('Add new') . '</i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right mr-1 btn-sm', 'escape' => false]) ?>
                </div>
            </header>
            <div class="panel-body">

                <?php if($workDayTypes->isEmpty()):?>
                    <?= $this->UIElements->alertBar([
                        'type'      => 'danger',
                        'message'   => __('No results found!')
                    ]); 
                    ?>
                <?php else: ?>
                <table class="table  table-hover general-table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', __('ID')) ?></th>
                            <th><?= $this->Paginator->sort('code') ?></th>
                            <th><?= $this->Paginator->sort('title') ?></th>
                            <th><?= $this->Paginator->sort('check_in_enabled', __('Check In')) ?></th>
                            <th><?= $this->Paginator->sort('default') ?></th>
                            <th class="text-right"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($workDayTypes as $workDayType):?>
                            <tr>
                                <td><?= $workDayType->id ?></td>
                                <?php $style = 'color: ' . $workDayType->color . ';' ; ?>
                                <td>
                                    <i class="fa fa-circle" style="<?= $style ?>"></i>
                                    <?= ' ' . h($workDayType->code) ?>
                                    <?php if($workDayType->is_weekend): ?>
                                        <i class="fa fa-rocket" style="color: orange;"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= h($workDayType->title) ?></td>
                                <td><?= $workDayType->getCheckInStatusName() ?></td>
                                <td>
                                    <?php if($workDayType->is_default) : ?>
                                        <span class="label label-success"><?= __('Yes') ?></span>
                                    <?php else :
                                        echo $this->Html->link(__('No'), ['action' => 'setDefault', $workDayType->id], ['class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => __('Set as default')]);
                                    ?>
                                    <?php endif; ?>
                                </td>                            
                                <td class="actions">
                                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $workDayType->id], ['class' => 'btn btn-warning pull-right btn-xs', 'escape' => false, 'title' => __('Edit')]) ?>
                                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $workDayType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workDayType->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                                    <?= $this->Html->link('<i class ="fa fa-info-circle"></i>', ['action' => 'view', $workDayType->id], ['class' => 'btn btn-info pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Show details')]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->UIElements->pagination($this->Paginator) ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
