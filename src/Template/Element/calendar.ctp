<div class="event-calendar clearfix">
    <div class="col-lg-6 calendar-block">
        <div class="cal1 ">
        </div>
    </div>
    <div class="col-lg-6 event-list-block">
        <div class="cal-day">
            <span>Today</span>
            <?= date('l') ?>
        </div>
        <ul class="event-list">
                    <?php 
                        foreach ($employeeBirthDay as $employee) 
                        {
                            echo '<li>' . '<i class="fa fa-star-o"></i>' . ' ' .  $employee->first_name . ' ' . $employee->last_name . ' birthday is:' . ' ' . date('d.m', strtotime($employee->birthdate)) . '<a href="#" class="event-close"><i class="ico-close2"></i></a></li>';
                        }
                        foreach ($employeeContractDay as $employee) 
                        {
                            echo '<li>' . '<i class="fa fa-calendar"></i>' . ' ' .  $employee->first_name . ' ' . $employee->last_name . ' contract date is:' . ' ' . date('d.m', strtotime($employee->contract_date)) . '<a href="#" class="event-close"><i class="ico-close2"></i></a></li>';
                        }
                    ?>
        </ul>
        <input type="text" class="form-control evnt-input" placeholder="NOTES">
    </div>
</div>