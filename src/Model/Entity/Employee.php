<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $title
 * @property string $photo_name
 * @property string $photo_path
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property \Cake\I18n\FrozenDate $birthdate
 * @property \Cake\I18n\FrozenDate $contract_date
 * @property string $uid
 * @property bool $allow_uid_access
 * @property bool $status
 */
class Employee extends Entity
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
        'first_name'        => true,
        'last_name'         => true,
        'title'             => true,
        'photo_name'        => true,
        'photo_path'        => true,
        'email'             => true,
        'password'          => true,
        'phone'             => true,
        'address'           => true,
        'city'              => true,
        'birthdate'         => true,
        'contract_date'     => true,
        'uid'               => true,
        'allow_uid_access'  => true,
        'status'            => true,
        'gender'            => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
           return (new DefaultPasswordHasher)->hash($password);
        }
    }

    public function getStatusName()
    {
        $employeesTable = TableRegistry::get('Employees');
        $statuses = $employeesTable->getStatuses();

        if(isset($statuses[$this->status]))
            return $statuses[$this->status];

        return "N/A";
    }

    public function getUidAccessName()
    {
        $employeesTable = TableRegistry::get('Employees');
        $uidAccess = $employeesTable->getUidAccess();

        if(isset($uidAccess[$this->allow_uid_access]))
            return $uidAccess[$this->allow_uid_access];

        return "N/A";

    }

    public function _getFullName()
    {
        $fullName = $this->first_name . " " . $this->last_name;
        
        if(!$this->status)
            $fullName .= " *";

        return $fullName;
    }

    public function getPhotoFullPath($thumbnailSize = "small")
    {
        $defaultPath = "/img/employees_defaults/".$thumbnailSize."_avatar_" . $this->gender . ".jpg";
        
        if(empty($this->photo_name))
            return $defaultPath;
        
        if(!file_exists(WWW_ROOT."files".DS."employees".DS."photo_name".DS.$this->photo_path.DS.$thumbnailSize."_".$this->photo_name))
            return $defaultPath;

        return "/files/employees/photo_name/" . $this->photo_path . "/" . $thumbnailSize . "_" . $this->photo_name;
    }

    public function getGenderName()
    {
        $employeesTable = TableRegistry::get('Employees');
        $gender = $employeesTable->getGender();
        
        if(isset($gender[$this->gender]))
            return $gender[$this->gender];

        return "N/A";
    }
}
