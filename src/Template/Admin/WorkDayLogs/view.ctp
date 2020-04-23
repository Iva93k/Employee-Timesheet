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
                <?= __('Work day log') ?>: <?= date($appConfData['dateFormat'], strtotime($workDayLog->work_day))?> | <?= !empty($workDayLog->employee) ? $workDayLog->employee->full_name : ""?>
                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $workDayLog->id], ['class' => 'btn btn-warning pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $workDayLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workDayLog->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                    <?= $this->Html->link('<i class ="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Add new')]) ?>
            </header>
            <div class="panel-body">
                <table class="table  table-hover general-table">
                    <tr>
                        <th scope="row"><?= __('Work day') ?></th>
                        <td><?= date($appConfData['dateFormat'], strtotime($workDayLog->work_day)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Employee') ?></th>
                        <td><?= $workDayLog->employee->full_name ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Work day type') ?></th>
                        <td><?= $workDayLog->work_day_type->code ?> | <?= $workDayLog->work_day_type->title ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Working time') ?></th>
                        <td>
                            <?php 
                                $style = "";
                                $icon = "fa fa-clock-o";
                                if($workDayLog->check_out_time->format('H:i') == "00:00")
                                    $style = "color: orange;";
                                
                                $time = $workDayLog->getTotalWorkTime();
                                if(!$time)
                                    $icon = "fa fa-rocket";
                            ?>
                            <i class="<?=$icon?>" style="<?=$style?>"></i>
                            <?= date($appConfData['timeFormat'], strtotime($workDayLog->check_in_time)) . ' - ' . date($appConfData['timeFormat'], strtotime($workDayLog->check_out_time))?>
                            (<?= $time ? $time : "--:--";?>)
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Auto logged') ?></th>
                        <td><?= $workDayLog->getAutoLoggedName(); ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($workDayLog->created)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= date($appConfData['dateTimeFormat'], strtotime($workDayLog->modified)) ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</div>