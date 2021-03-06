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
    ]
]);
?>
<?= $this->Flash->render() ?>
<section class="panel">
    <div class="panel-body">
        <?= $this->Form->create('', ['type' => 'get']) ?>
            <div class="row">
                <div class="col-lg-1">
                    <?= $this->Form->control('id', ['label' => __('ID'), 'default' => $this->request->getQuery('id'), 'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-2">
                    <?= $this->Form->control('name', ['label' => __('Name'), 'default' => $this->request->getQuery('name'), 'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-2">
                    <?= $this->Form->control('title', ['label' => __('Title'), 'default' => $this->request->getQuery('title'), 'class' => 'form-control']) ?>
                </div>
                <div class="col-lg-2">
                    <?= $this->Form->control('email', ['label' => __('Email'), 'default' => $this->request->getQuery('email'), 'class' => 'form-control', 'type' => 'text']) ?>
                </div>
                <div class="col-lg-1">
                    <label for="status"><?= __('Status') ?></label>
                    <?= $this->Form->select('status', ['' => __("All")] + $statusList, ['default' => $this->request->getQuery('status') != null ? (integer)$this->request->getQuery('status') : '']); ?> 
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
                <?= __('Employees') ?>
                <div class="indexActionButtons pull-right">
                    <?= $this->Html->link('<i class ="fa fa-plus"> ' . __('Add new') . '</i>', ['action' => 'add'], ['class' => 'btn btn-success pull-right mr-1 btn-sm', 'escape' => false]) ?>
                </div>
            </header>
            <div class="panel-body">

                <?php if($employees->isEmpty()):?>
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
                            <th><?= __('Photo') ?></th>
                            <th><?= $this->Paginator->sort('first_name') ?></th>
                            <th class="hidden-phone"><?= $this->Paginator->sort('last_name') ?></th>
                            <th><?= $this->Paginator->sort('title') ?></th>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th><?= $this->Paginator->sort('phone') ?></th>
                            <th><?= $this->Paginator->sort('status') ?></th>
                            <th class="text-right"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee):?>
                            <tr>
                                <td><?= $employee->id ?></td>
                                <td>
                                    <?= $this->Html->image($employee->getPhotoFullPath(), ['width' => 50]); ?>
                                </td>
                                <td><?= h($employee->first_name) ?></td>
                                <td><?= h($employee->last_name) ?></td>
                                <td><?= h($employee->title) ?></td>
                                <td><?= h($employee->email) ?></td>
                                <td><?= h($employee->phone) ?></td>
                                <td>
                                    <?php if($employee->status == 1): ?>
                                        <span class="label label-success"><i class="fa fa-check-circle"></i></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><i class="fa fa-minus-circle"></i></span>
                                    <?php endif; ?>
                                </td>                           
                                <td class="actions">
                                    <?= $this->Html->link('<i class ="fa fa-edit"></i>', ['action' => 'edit', $employee->id], ['class' => 'btn btn-warning pull-right btn-xs', 'escape' => false, 'title' => __('Edit')]) ?>
                                    <?= $this->Form->postLink('<i class ="fa fa-times-circle"></i>', ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'btn btn-danger pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Delete')]) ?>
                                    <?= $this->Html->link('<i class ="fa fa-info-circle"></i>', ['action' => 'view', $employee->id], ['class' => 'btn btn-info pull-right btn-xs mr-1', 'escape' => false, 'title' => __('Show details')]) ?>
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