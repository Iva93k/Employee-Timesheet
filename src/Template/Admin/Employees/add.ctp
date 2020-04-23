<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => "fa fa-users",
        'url'       => "/admin/employees",
        'title'     => __('List employees')
    ],
    [
        'iconClass' => false,
        'url'       => false,
        'title'     => __('Add')
    ]
]) ?>
<?= $this->Flash->render(); ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Employees') ?>
            </header>
            <div class="panel-body">
                <div class="administrators form large-9 medium-8 columns content">
                    <?= $this->Form->create($employee, ['type' => 'file']) ?>
                        <div class="col-lg-6">
                            <fieldset>
                                <?php
                                    echo $this->Form->control('first_name', ['class' => "form-control"]);
                                    echo $this->Form->control('last_name', ['class' => "form-control"]); 
                                    echo $this->Form->control('title', ['class' => "form-control"]);
                                    echo $this->Form->control('email', ['class' => "form-control"]);
                                    echo $this->Form->control('password', ['class' => "form-control"]);
                                    echo $this->Form->control('phone', ['class' => "form-control"]);
                                    echo $this->Form->control('address', ['class' => "form-control"]);
                                ?>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <?php     
                                    echo $this->Form->control('city', ['class' => "form-control"]);
                                    echo $this->Form->control('birthdate', ['class' => "form-control input-date-picker", 'type' => 'text', 'label' => 'Birth date']);
                                    echo $this->Form->control('contract_date', ['class' => "form-control input-date-picker", 'type' => 'text']);
                                    echo $this->Form->control('uid', ['class' => "form-control", 'label' => 'UID']);
                                ?>
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label for="gender"><?=__('Gender')?></label>                                
                                        <?= $this->Form->select('gender', ['' => __("None")] + $genderList) ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <label><?= __('Image') ?></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <span class="btn btn-white btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> <?= __('Select image') ?></span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> <?= __('Change') ?></span>
                                                <?= $this->Form->file('photo_name', ['class' => 'default']); ?>
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <?php 
                                                if ($this->Form->isFieldError('photo_name')) {
                                                    echo $this->Form->error('photo_name', ['message']);
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?= $this->Form->control('allow_uid_access', ['class' => 'icheck-style']); ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?= $this->Form->control('status', ['class' => 'icheck-style']); ?>
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

