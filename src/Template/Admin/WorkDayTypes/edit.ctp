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
        'title'     => __('Edit')
    ]
]) ?>
<?= $this->Flash->render() ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Work day type') ?>: <?= $workDayType->code . " - " . $workDayType->title ?>
                <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $workDayType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workDayType->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
            </header>
            <div class="panel-body">
                <div class="administrators form large-9 medium-8 columns content">
                    <?= $this->Form->create($workDayType) ?>
                    <div class="row">
                            <div class="col-lg-2">
                                <?= $this->Form->control('code', ['class' => "form-control"]); ?>
                            </div>
                            <div class="col-lg-10">
                                <?= $this->Form->control('title', ['class' => "form-control"]); ?>
                            </div>
                        </div>
                        <fieldset>
                            <div class="row">
                                <div class="col-lg-2">
                                    <?= $this->Form->control('color', ['class' => 'colorpicker-default form-control', 'type' => 'text', 'default' => '#eeeeee']); ?>
                                </div>
                                <div class="col-lg-10">
                                    <?= $this->Form->control('description', ['class' => "form-control"]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <?= $this->Form->control('check_in_enabled', ['class' => 'icheck-style']); ?>
                                    <small class="form-text text-muted"><?= __('This option is related to client side') ?></small>
                                </div>
                                <div class="col-lg-2">
                                    <?= $this->Form->control('is_default', ['class' => 'icheck-style']); ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $this->Form->control('payed', ['class' => 'icheck-style']); ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $this->Form->control('is_weekend', ['type' => 'checkbox']); ?>
                                </div>                             
                                <div class="col-lg-2" id="weekend" style="<?= $workDayType->is_weekend ? 'display: inline;' : 'display: none;' ;?>">
                                    <?php 
                                        for ($i=1; $i<=7 ; $i++):                                    
                                            echo $this->Form->control("weekend_days[".$i."]", ['label' => jddayofweek(($i-1), 1), 'class' => 'icheck-style', 'type' => 'checkbox', 'checked' => isset($weekendDays[$i]) ? true : false]);
                                        endfor;
                                    ?>
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