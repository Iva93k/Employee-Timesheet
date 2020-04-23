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
    ],
    [
        'iconClass' => "fa fa-eye",
        'url'       => false,
        'title'     => __('Preview')
    ]
]);
?>

<?= $this->Flash->render() ?>

<?php 
$year = date('Y');
if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
    $year = $queryParams['year']['year'];

$month = date('m');
if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
    $month = $queryParams['month']['month'];

$monthDays = cal_days_in_month(CAL_GREGORIAN , $month , $year);
?>

<section class="panel">
    <div class="panel-body">
        <?= $this->Form->create('', ['type' => 'get']) ?>
            <div class="row">
                <div class="col-lg-2">
                    <label for="employee_id"><?= __('Employee') ?></label>
                    <?= $this->Form->select('employee_id', ['' => __("All")] + $employeesList, ['options' => $employeesList, 'default' =>  $this->request->getQuery('employee_id')]); ?>
                </div>
                <div class="col-lg-2">
                    <?=  $this->Form->control('month', ['type' => 'month', 'default' => $this->request->getQuery('month'), 'empty' => date('F')]); ?>
                </div>
                <div class="col-lg-2">
                    <?=  $this->Form->control('year', ['type' => 'year', 'default' => $this->request->getQuery('year'), 'maxYear' => date('Y'), 'minYear' => $filterMinYear, 'empty' => date('Y')]); ?>
                </div>
                <div class="col-lg-1">
                    <br>
                    <?= $this->Form->submit(__('Search'), ['class' => 'btn btn-info input-group-text pull-right'])?>
                </div>
                <?php if(!empty($this->request->getQueryParams())):?>
                <div class="col-lg-1">
                    <br>
                    <?= $this->Html->link(__('Reset'), ['action' => 'preview'], ['class' => 'btn btn-warning input-group-text pull-left']) ?>
                </div>  
                <?php endif; ?>      
            </div>
         <?= $this->Form->end();?>
    </div>
</section>

<div id="printPage">
    <section class="panel">
        <header class="panel-heading no-border">
            <?= __('Monthly preview') . ' ('?>
            <?= (isset($queryParams['month']['month']) && !empty($queryParams['month']['month'])) ? date('F', mktime (0, 0, 0 , $queryParams['month']['month'], 19)) : date('F') ?>
            <?= ')' ?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
            </span>
            <?= $this->Html->link('<i class="fa fa-download" style="color:#00aaff;"></i>', 
                ['action' => 'exportExcelfile', 
                    'employee_id'   => (isset($queryParams['employee_id']) && !empty($queryParams['employee_id'])) ? $queryParams['employee_id'] : null,
                    'month[month]'  => (isset($queryParams['month']['month']) && !empty($queryParams['month']['month'])) ? $queryParams['month']['month'] : null,
                    'year[year]'    => (isset($queryParams['year']['year'])  && !empty($queryParams['year']['year'])) ? $queryParams['year']['year'] : null
                ], 
                ['class' => 'btn btn-default btn-xs pull-right', 'escape' => false, 'title' => __("Download")]) 
            ?>
            <a href="javascript:void(0);" class="btn btn-default btn-xs mr-1 pull-right" id="printPreview" title="<?=__('Print')?>"><span class="fa fa-print"></span></a>
        </header>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?= __('R/B') ?></th>
                        <th><?= __('Last name and first name')?></th>
                        <?php 
                            for ($i=1; $i<=$monthDays; $i++):
                        ?>
                        <th class="center"><?= $i ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        foreach ($employees as $employee):
                            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']) && $queryParams['employee_id'] != $employee->id)
                                continue;
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <?php $i++;?>
                            <td>
                                <?= $employee->full_name ?>
                            </td>                       
                            <?php
                                for ($dayInMonth=1; $dayInMonth <= $monthDays; $dayInMonth++):
                                    
                                    $style = '';
                                    if(isset($preparedData[$employee->id]) && isset($preparedData[$employee->id][$dayInMonth]))
                                        $style = 'background-color:' .  $workDayTypesColors[$preparedData[$employee->id][$dayInMonth]['wdtID']] . ';';         
                            ?>
                                <td class="center" style="<?=$style?>">
                                    <?php if(isset($preparedData[$employee->id]) && isset($preparedData[$employee->id][$dayInMonth])) 
                                        echo $this->Html->link($workDayTypesList[$preparedData[$employee->id][$dayInMonth]['wdtID']], ['action' => 'view/' . $preparedData[$employee->id][$dayInMonth]['wdlID']]);
                                    else
                                        echo $this->Html->link('<span class="change-icon"><i class="fa fa-minus"></i><i class="fa fa-plus green-icon"></i></span>', 
                                            [
                                                'action'=> 'add', 
                                                '?'     => ['employee_id' => $employee->id, 'work_day' => $dayInMonth.'.'.$month.'.'.$year],
                                            ], 
                                            ['class' => 'hover' , 'escape' => false]
                                        );
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>          
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <div class="row">
        <div class="col-sm-4">
            <section class="panel">
                <header class="panel-heading">
                    <?= __('Work day types')?>
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Title') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($workDayTypes as $workDayType): ?>
                                <?php $style = 'color: ' . $workDayType->color . ';' ; ?>
                                <tr>
                                    <td><i class="fa fa-circle" style="<?= $style ?>"></i><?= ' ' . h($workDayType->code) ?></td>
                                    <td><?= h($workDayType->title) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>