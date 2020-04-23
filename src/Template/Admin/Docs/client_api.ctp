<link rel="stylesheet" href="/webroot/admin-assets/css/xcode.css">
<script src="/webroot/admin-assets/js/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<?= $this->UIElements->breadcrumb([
    [
        'iconClass' => "fa fa-dashboard",
        'url'       => "/admin/",
        'title'     => __('Dashboard')
    ],
    [
        'iconClass' => null,
        'url'       => false,
        'title'     => __('Client API')
    ]
]);
?>

<?= $this->Flash->render() ?>

<section class="panel">
   <div class="panel-body">
       <div class="markdown-body">
           <?=$text?>
       </div>
   </div>
</section>