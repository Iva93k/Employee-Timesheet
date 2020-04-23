<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => null,
        'url'       => false,
        'title'     => __('Check in log')
    ]
]);
?>

<?= $this->Flash->render() ?>

<section class="panel">
   <div class="panel-body">
       <div class="markdown-body">
        	<?= nl2br($checkInContent) ?>
       </div>
   </div>
</section>