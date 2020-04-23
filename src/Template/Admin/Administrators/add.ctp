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
        'title'     => __('Add')
    ]
]) ?>
<?= $this->Flash->render(); ?>
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= __('Administrators') ?>
            </header>
            <div class="panel-body">
                <div class="administrators form large-9 medium-8 columns content">
                    <?= $this->Form->create($administrator) ?>
                    <div class="col-lg-6">
                        <fieldset>
                            <?php
                                echo $this->Form->control('first_name', ['class' => "form-control"]);
                                echo $this->Form->control('last_name', ['class' => "form-control"]); 
                                echo $this->Form->control('password', ['class' => "form-control"]); 
                            ?>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <fieldset>
                            <?= $this->Form->control('email', ['class' => "form-control"]);?>
                            <div class="form-group">
                                <label for="role"><?=__("Role")?></label>                                
                                <?= $this->Form->select('role', $roleList) ?>
                            </div>
                            <?= $this->Form->control('status', ['class' => 'icheck-style']); ?>
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
