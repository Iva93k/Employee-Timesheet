<?= $this->Flash->render() ?>
<!--mini statistics start-->
<div class="row">
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <a href="/admin/work-day-logs">
                <span class="mini-stat-icon orange">
                    <i class="fa fa-calendar"></i>
                </span>
            </a>
            <div class="mini-stat-info">
                <a href="/admin/work-day-logs">
                    <span><?= __('Work days') ?></span>
                </a>
                <a href="/admin/work-day-logs">
                    <?= $firstWorkDayTime . ' - ' . $lastWorkDayTime ?>
                </a>         
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <a href="/admin/employees">
                <span class="mini-stat-icon pink">
                    <i class="fa fa-group"></i>
                </span>
            </a>
            <div class="mini-stat-info">
                <a href="/admin/employees">
                    <span><?= __('Employees') ?></span>
                </a>
                <a href="/admin/employees">
                    <?= $countEmployees ?>
                </a>      
            </div>
        </div>
    </div> 
    <div class="col-md-4">
        <div class="mini-stat clearfix">
            <a href="/admin/administrators">
                <span class="mini-stat-icon tar">
                    <i class="fa fa-user"></i>
                </span>
            </a>
            <div class="mini-stat-info">
                <a href="/admin/administrators">
                    <span><?= __('Administrators') ?></span>
                </a>
                <a href="/admin/administrators">
                    <?= $countAdministrators ?>
                </a>      
            </div>
        </div>
    </div> 
</div>
<!--mini statistics end-->
<div class="row">
    <div class="col-md-8">
        <?= $this->element('calendar'); ?>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <?= $this->element('clock'); ?>
            </div>
            <div class="col-md-12">
                <?= $this->element('company'); ?>
            </div>
        </div>
    </div>
</div>
    