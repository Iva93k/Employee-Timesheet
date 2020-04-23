<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrator $administrator
 */
?>
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
    <?= $this->Html->css('/admin-assets/css/style') ?>
    <?= $this->Html->css('/admin-assets/css/style-responsive') ?>
    <?= $this->Html->css('/admin-assets/css/admin') ?>

    <?= $this->Html->script('/admin-assets/js/jquery'); ?>
    <?= $this->Html->script('/admin-assets/js/bootstrap.min'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.dcjqaccordion.2.7'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.scrollTo.min'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.slimscroll'); ?>
    <?= $this->Html->script('/admin-assets/js/jquery.nicescroll'); ?>

    <?= $this->Html->script('/admin-assets/js/scripts'); ?>
    <?= $this->Html->script('/admin-assets/js/admin'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <?php echo $this->fetch('content') ?>
</body>
</html>