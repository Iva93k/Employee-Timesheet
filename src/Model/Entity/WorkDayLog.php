<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * WorkDayLog Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $log_day
 * @property \Cake\I18n\FrozenTime $check_in_time
 * @property \Cake\I18n\FrozenTime $check_out_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $employee_id
 * @property int $work_day_type_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\WorkDayType $work_day_type
 */
class WorkDayLog extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'work_day'          => true,
        'check_in_time'     => true,
        'check_out_time'    => true,
        'auto_logged'       => true,
        'created'           => true,
        'modified'          => true,
        'employee_id'       => true,
        'work_day_type_id'  => true,
        'employee'          => true,
        'work_day_type'     => true
    ];

    //Work Time in format H:i (hours & minutes)
    public function getTotalWorkTime($lunchBrakeTime = null)
    {
        $workDayType = null;
        if(isset($this->work_day_type)) 
            $workDayType = $this->work_day_type;
        else
            $workDayType = TableRegistry::get('WorkDayTypes')->find()->select('is_weekend')->where(['id' => $this->work_day_type_id])->first();

        if($workDayType->is_weekend)
            return null;

        if(empty($lunchBrakeTime))
        {
            $company = TableRegistry::get('Companies')->find()->select('lunch_break')->order(['id' => 'DESC'])->first();
            $lunchBrakeTime = $company->lunch_break;
        }

        $checkInTime = new \DateTime($this->check_in_time->format('Y-m-d H:i'));

        if($this->check_out_time->format('H:i') == "00:00")
            $checkOutTime = new \DateTime();
        else
            $checkOutTime = new \DateTime($this->check_out_time->format('Y-m-d H:i'));

        $diff = $checkOutTime->diff($checkInTime);

        $totalMinutes = ($diff->h * 60) + $diff->i;
        
        if($totalMinutes >= 270)
            $totalMinutes -= (int)$lunchBrakeTime;

        $hours = (int)($totalMinutes / 60);
        $minutes = $totalMinutes - ($hours * 60);

        if($hours < 10)
            $hours = "0" . $hours;

        if($minutes < 10)
            $minutes = "0" . $minutes;

        return $hours . ":" . $minutes;
    }

    public function getAutoLoggedName()
    {
        $workDayLogsTable = TableRegistry::get('WorkDayLogs');
        $autoLogged = $workDayLogsTable->getAutoLogged();

        if(isset($autoLogged[$this->auto_logged]))
            return $autoLogged[$this->auto_logged];

        return "N/A";
    }
}
