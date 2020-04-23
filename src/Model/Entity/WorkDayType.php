<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * WorkDayType Entity
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool|null $check_in_enabled
 */
class WorkDayType extends Entity
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
        'code'                  => true,
        'title'                 => true,
        'description'           => true,
        'created'               => true,
        'modified'              => true,
        'check_in_enabled'      => true,
        'is_default'            => true,
        'is_weekend'            => true,
        'weekend_days'          => true,
        'color'                 => true,
        'payed'                 => true
    ];

    public function getCheckInStatusName()
    {
        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $checkInStatuses = $workDayTypesTable->getCheckInStatuses();

        if(isset($checkInStatuses[$this->check_in_enabled]))
            return $checkInStatuses[$this->check_in_enabled];

        return "N/A";
    }

    public function getIsDefaultStatusName()
    {
        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $isDefaultStatuses = $workDayTypesTable->getIsDefaultStatuses();

        if(isset($isDefaultStatuses[$this->is_default]))
            return $isDefaultStatuses[$this->is_default];

        return "N/A";
    }

    public function getIsWeekendStatusName()
    {
        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $isWeekendStatuses = $workDayTypesTable->getIsWeekendStatuses();

        if(isset($isWeekendStatuses[$this->is_weekend]))
            return $isWeekendStatuses[$this->is_weekend];

        return "N/A";
    }

    public function getWeekendDays()
    {
        $weekendDays = [];

        if(empty($this->weekend_days))
            return $weekendDays;
        
        $weekendDaysDecoded = json_decode($this->weekend_days, true);

        foreach ($weekendDaysDecoded as $day => $value) 
        {
            if(!empty($value) && $value != "0")
                $weekendDays[$day] = true;
        }
        
        return $weekendDays;
    }

    public function getPayedStatusName()
    {
        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $payedStatuses = $workDayTypesTable->getPayedStatuses();

        if(isset($payedStatuses[$this->payed]))
            return $payedStatuses[$this->payed];

        return "N/A";
    }
}
