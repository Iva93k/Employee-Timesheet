<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title .  ' | ' .  $appConfData['name'];?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('/homepage/css/style') ?>
    <?= $this->Html->css('/homepage/css/responsive') ?>
    <?= $this->Html->css('/homepage/css/bootstrap') ?>
    <?= $this->Html->css('/homepage/css/font-awesome.min') ?>
    <?= $this->Html->css('/homepage/css/simpleLightbox') ?>
    <?= $this->Html->css('/homepage/css/linericon') ?>
    <?= $this->Html->css('/homepage/css/home') ?>

    <?= $this->Html->script('/homepage/js/jquery-3.2.1.min') ?>
    <?= $this->Html->script('/homepage/js/popper') ?>
    <?= $this->Html->script('/homepage/js/bootstrap.min') ?>
    <?= $this->Html->script('/homepage/js/stellar') ?>
    <?= $this->Html->script('/homepage/js/simpleLightbox.min') ?>
    <?= $this->Html->script('/homepage/js/jquery.nice-select') ?>
    <?= $this->Html->script('/homepage/js/jquery.ajaxchimp.min') ?>
    <?= $this->Html->script('/homepage/js/jquery.waypoints.min') ?>
    <?= $this->Html->script('/homepage/js/jquery.counterup.min') ?>
    <?= $this->Html->script('/homepage/js/bootstrap-datetimepicker.min') ?>
    <?= $this->Html->script('/homepage/js/custom') ?>
    <?= $this->Html->script('/homepage/js/theme') ?>

</head>

<body>
    <?php echo $this->fetch('content') ?>
</body>
</html>