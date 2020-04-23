<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title .  ' | ' .  $appConfData['name'];?>
    </title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('/admin-assets/css/bootstrap.min') ?>
    <?= $this->Html->css('/admin-assets/css/bootstrap-reset') ?>
    <?= $this->Html->css('/admin-assets/css/font-awesome') ?>
    <?= $this->Html->css('/admin-assets/css/clockstyle') ?>
    <?= $this->Html->css('/admin-assets/css/style') ?>
    <?= $this->Html->css('/admin-assets/css/style-responsive') ?>
    <?= $this->Html->css('/admin-assets/iCheck/skins/minimal/minimal') ?>
    <?= $this->Html->css('/admin-assets/css/admin') ?>
    <?= $this->Html->css('/admin-assets/css/bootstrap-fileupload') ?>
    <?= $this->Html->css('/admin-assets/css/datepicker') ?>
    <?= $this->Html->css('/admin-assets/css/timepicker') ?>
    <?= $this->Html->css('/admin-assets/css/colorpicker') ?>
    <?= $this->Html->css('/admin-assets/css/clndr') ?>

    <?= $this->Html->script('/admin-assets/js/jquery'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap.min'); ?>
    
    <?= $this->Html->script('/admin-assets/js/moment.min'); ?>

    <?= $this->Html->script('/admin-assets/js/jquery.dcjqaccordion.2.7'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.scrollTo.min'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.slimscroll'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.slimscroll.min'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery-1.10.2.min'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery-ui-1.9.2.custom.min'); ?>
    <?= $this->Html->script('/admin-assets/iCheck/jquery.icheck.js'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap-fileupload'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap-datepicker'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap-timepicker'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap-colorpicker'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.nicescroll'); ?>
    <?= $this->Html->script('/admin-assets/js/css3clock'); ?>
    <?= $this->Html->script('/admin-assets/js/clndr'); ?>
    <?= $this->Html->script('/admin-assets/js/underscore-min.js'); ?>
    <?= $this->Html->script('/admin-assets/js/moment-2.2.1'); ?>
    <?= $this->Html->script('/admin-assets/js/evnt.calendar.init'); ?>


    <?= $this->Html->script('/admin-assets/js/scripts'); ?>
    <?= $this->Html->script('/admin-assets/js/admin'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<section id="container">
    <header class="header fixed-top clearfix">
        <div class="brand">
            <a href="/admin/" class="logo">
                <img src="/admin-assets/img/cake-logo.png" alt="" width="90%"/>
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!-- Logo end -->
        <div class="nav notify-row" id="top_menu"> 
            <!--  notification start -->
            <ul class="nav top-menu">          
                <!-- settings start -->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="fa fa-gear"></i>
                    </a>
                    <ul class="dropdown-menu extended tasks-bar">
                        <li>
                            <p class=""><?= __('Developer tools') ?></p>
                        </li>
                        <li>
                            <a href="/admin/docs/client_api">
                                <div class="task-info clearfix">
                                    <div class="desc pull-left">
                                        <h5><?= __('Client API') ?></h5>
                                        <p><?= __('Client API documentation') ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/dashboard/read-check-in-log">
                                <div class="task-info clearfix">
                                    <div class="desc pull-left">
                                        <h5><?= __('Check in log') ?></h5>
                                        <p><?= __('Check in log') ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/dashboard/read-check-out-log">
                                <div class="task-info clearfix">
                                    <div class="desc pull-left">
                                        <h5><?= __('Check out log') ?></h5>
                                        <p><?= __('Check out log') ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- settings end -->
            </ul>
        </div>
        <div class="top-nav clearfix">
            <ul class="nav pull-right top-menu">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle icon-user" href="#">  
                        <i class="fa fa-user"></i>
                        <span class="username"><?= $authUserData ? $authUserData['first_name'] . " " . $authUserData['last_name'] : ""; ?></span>
                        <b class="caret"></b> 
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="<?=$this->Url->build('admin/administrators/profile');?>"><i class=" fa fa-suitcase"></i><?= __('Profile') ?></a></li>
                        <li><a href="<?=$this->Url->build('admin/administrators/logout');?>"><i class="fa fa-key"></i><?= __('Log Out') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    <aside>
        <?= $this->element('sidebar'); ?>
    </aside>
    
    <section id="main-content">
        <section class="wrapper">
            <?= $this->fetch('content') ?>
        </section>
    </section>
</section>
</body>
</html>
