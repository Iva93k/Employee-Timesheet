<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-suitcase",
        'url'       => "/admin/company",
        'title'     => __('Company')
    ],
    [
        'iconClass' => false,
        'url'       => false,
        'title'     => __('Add company')
    ]
]) ?>
<?= $this->Flash->render(); ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Companies') ?>
            </header>
            <div class="panel-body">
                <div class="administrators form large-9 medium-8 columns content">
                    <?= $this->Form->create($company) ?>
                    <div class="col-lg-6">
                        <fieldset>
                            <?php
                                echo $this->Form->control('name', ['class' => "form-control"]);
                                echo $this->Form->control('address', ['class' => "form-control"]); 
                                echo $this->Form->control('city', ['class' => "form-control"]);
                                echo $this->Form->control('phone_number', ['class' => "form-control"]);
                                echo $this->Form->control('fax', ['class' => "form-control"]);
                                echo $this->Form->control('id_number', ['class' => "form-control", 'label' => __('ID Number')]);
                            ?>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <fieldset>
                            <?php 
                                echo $this->Form->control('tax_number', ['class' => "form-control", 'label' => __('TAX Number')]);
                                echo $this->Form->control('email', ['class' => "form-control"]);
                                echo $this->Form->control('web', ['class' => "form-control"]);
                                echo $this->Form->control('contact_person', ['class' => "form-control"]);
                            ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= $this->Form->control('start_working_time', ['class' => "form-control timepicker-24", 'type' => 'text']); ?>
                                </div>
                                <div class="col-lg-6">
                                    <?= $this->Form->control('end_working_time', ['class' => "form-control timepicker-24", 'type' => 'text']); ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $this->Form->control('lunch_break', ['class' => "form-control", 'label' => __('Lunch break'), 'min' => 0, 'max' => 120]); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-12">
                        <?= $this->Form->submit(__('Save'), ['class' => 'btn btn-primary pull-right']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div> 
            </div>
        </section>
    </div>
</div>
