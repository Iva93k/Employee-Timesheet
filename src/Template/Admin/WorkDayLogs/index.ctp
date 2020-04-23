<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-calendar",
        'url'       => "/admin/work-day-logs",
        'title'     => __('List work days')
    ]
]);
?>
<?= $this->Flash->render() ?>
<section class="panel">
    <div class="panel-body">
        <?= $this->Form->create('', ['type' => 'get']) ?>
            <div class="row">
                <div class="col-lg-1">
                    <label for="work_day_type_id"><?= __('Work day type') ?></label>
                    <?= $this->Form->select('work_day_type_id', ['' => __("All")] + $workDayTypesList, ['options' => $workDayTypesList, 'default' =>  $this->request->getQuery('work_day_type_id')]); ?>
                </div>
                <div class="col-lg-2">
                    <label for="employee_id"><?= __('Employee') ?></label>
                    <?= $this->Form->select('employee_id', ['' => __("All")] + $employeesList, ['options' => $employeesList, 'default' =>  $this->request->getQuery('employee_id')]); ?>
                </div>
                <div class="col-lg-2">
                    <?= $this->Form->control('day', ['type' => 'day', 'default' => $this->request->getQuery('day'), 'empty' => __("Select day")]); ?>
                </div>
                <div class="col-lg-2">
                    <?=  $this->Form->control('month', ['type' => 'month', 'default' =>  $this->request->getQuery('month'), 'empty' => __("Select month")]); ?>
                </div>
                <div class="col-lg-2">
                    <?=  $this->Form->control('year', ['type' => 'year', 'default' =>  $this->request->getQuery('year'), 'maxYear' => date('Y'), 'minYear' => $filterMinYear, 'empty' => __("Select year")]); ?>
                </div>
                <div class="col-lg-1">
                    <br>
                    <?= $this->Form->submit(__('Search'), ['class' => 'btn btn-info input-group-text pull-right'])?>
                </div>
                <?php if(!empty($this->request->getQueryParams())):?>
                <div class="col-lg-1">
                    <br>
                    <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'btn btn-warning input-group-text pull-left']) ?>
                </div>  
                <?php endif; ?>      
            </div>
         <?= $this->Form->end();?>
    </div>
</section>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Work day logs') ?>
                <div class="indexActionButtons pull-right">
                    <?= $this->Html->link('<i class ="fa fa-eye"> ' . __('Preview') . '</i>', ['action' => 'preview'], ['class' => 'btn btn-info pull-right mr-1 btn-sm', 'escape' => false]) ?>
                </div>
                <div class="indexActionButtons pull-right">
                    <?= $this->Html->link('<i class ="fa fa-plus"> ' . __('Add new') . '</i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right mr-1 btn-sm', 'escape' => false]) ?>
                </div>
            </header>
            <div class="panel-body">

                <?php if($workDayLogs->isEmpty()):?>
                    <?= $this->UIElements->alertBar([
                        'type'      => 'danger',
                        'message'   => __('No results found!')
                    ]); 
                    ?>
                <?php else: ?>
                <table class="table  table-hover general-table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('work_day') ?></th>
                            <th><?= __("Time")?> (H:i)</th>
                            <th><?= $this->Paginator->sort('employee_id') ?></th>
                            <th><?= $this->Paginator->sort('work_day_type_id') ?></th>
                            <th class="text-right"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($workDayLogs as $workDayLog):?>
                            <tr>
                                <td><?= date($appConfData['dateFormat'], strtotime($workDayLog->work_day)) ?></td>
                                <td>
                                    <?php 
                                    $style = "";
                                    $icon = "fa fa-clock-o";
                                    if($workDayLog->check_out_time->format('H:i') == "00:00")
                                        $style = "color: orange;";
                                    
                                    $time = $workDayLog->getTotalWorkTime($company->lunch_break);
                                    if(!$time)
                                        $icon = "fa fa-rocket";
                                    ?>
                                    <i class="<?=$icon?>" style="<?=$style?>"></i>
                                    <?= $time ? $time : "--:--"; ?>
                                </td>
                                <td><?= h($workDayLog->employee->full_name) ?></td>
                                <td><?= h($workDayLog->work_day_type->title) ?></td>                           
                                <td class="actions">
                                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $workDayLog->id], ['class' => 'btn btn-warning pull-right btn-xs', 'escape' => false, 'title' => __('Edit')]) ?>
                                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $workDayLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workDayLog->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                                    <?= $this->Html->link('<i class ="fa fa-info-circle"></i>', ['action' => 'view', $workDayLog->id], ['class' => 'btn btn-info pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Show details')]) ?>
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