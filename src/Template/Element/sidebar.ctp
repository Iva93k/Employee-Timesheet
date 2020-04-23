<div id="sidebar" class="nav-collapse">
    <!-- sidebar menu start-->            
    <div class="leftside-navigation">
        <ul class="sidebar-menu" id="nav-accordion">
        <li>
            <a href="/admin/dashboard">
                <i class="fa fa-dashboard"></i>
                <span><?= __('Dashboard') ?></span>
            </a>
        </li>
        <li>
            <a href="/admin/company">
                <i class="fa fa-suitcase"></i>
                <span><?= __('Company') ?></span>
            </a>
        </li>
        <li>
            <a href="/admin/employees">
                <i class="fa fa-group"></i>
                <span><?= __('Employees') ?></span>
            </a>
        </li>
        <li>
            <a href="/admin/work-day-logs">
                <i class="fa fa-calendar"></i>
                <span><?= __('Work days') ?></span>
            </a>
        </li>
        <li>
            <a href="/admin/work-day-types">
                <i class="fa fa-check-square-o"></i>
                <span><?= __('Work day types') ?></span>
            </a>
        </li>
        <li>
            <a href="<?=$this->Url->build('/admin/administrators');?>">
                <i class="fa fa-user"></i>
                <span><?= __('Administrators') ?></span>
            </a>
        </li>       
    <!-- sidebar menu end-->
</div>