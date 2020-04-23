<div class="mini-stat clearfix">
    <a href="/admin/company">
        <span class="mini-stat-icon default">
            <i class="fa fa-building-o"></i>
        </span>
    </a>
    <div class="mini-stat-info">
        <a href="/admin/company">
            <span><?= $company['name'] ?></span>
        </a>
        <a href="/admin/company">
            <?= $company['address'] . ", " . $company['city'] ?>
        </a>
        <hr style="margin: 7px 0px 5px 0px;" />
    </div>
    <ul class="clearfix prospective-spark-bar">
        <li class="pull-left spark-bar-label">
            <span class="bar-label-value"><?= date($appConfData['timeFormat'], strtotime($company->start_working_time)) . ' - ' . date($appConfData['timeFormat'], strtotime($company->end_working_time))?></span>
            <span><?= __("Work time")?></span>
        </li>
        <li class="pull-right spark-bar-label">
            <span class="bar-label-value"><?= $company['lunch_break']?> min</span>
            <span><?= __("Lunch brake") ?></span>
        </li>
    </ul>
</div>