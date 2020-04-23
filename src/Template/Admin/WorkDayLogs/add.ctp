<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-calendar",
        'url'       => "/admin/work-day-logs",
        'title'     => __('Work day logs')
    ],
    [
        'iconClass' => false,
        'url'       => false,
        'title'     => __('Add work day log')
    ]
]) ?>
<?= $this->Flash->render(); ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Work day logs') ?>
            </header>
            <div class="panel-body">
                <div class="administrators form large-9 medium-8 columns content">
                    <?= $this->Form->create($workDayLog) ?>
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= $this->Form->control('employee_id', ['options' => $employeesList]); ?>
                                </div>
                                <div class="col-lg-6">
                                    <?= $this->Form->control('work_day_type_id', ['options' => $workDayTypesList]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= $this->Form->control('work_day', ['class' => "form-control input-date-picker", 'type' => 'text', 'label' => 'Work day', 'default' => date($appConfData['dateFormat'])]); ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $this->Form->control('check_in_time', ['class' => "form-control timepicker-24", 'type' => 'text', 'default' => date($appConfData['timeFormat'], strtotime($company->start_working_time))]); ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $this->Form->control('check_out_time', ['class' => "form-control timepicker-24", 'type' => 'text', 'default' => date($appConfData['timeFormat'], strtotime($company->end_working_time))]); ?>
                                </div>
                            </div>
                        </fieldset>
                        <div class="col-lg-12">
                            <?= $this->Form->submit(__('Save'), ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                    <?= $this->Form->end() ?>
                </div> 
            </div>
        </section>
    </div>
</div>