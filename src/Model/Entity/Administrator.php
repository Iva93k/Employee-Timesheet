<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

/**
 * Administrator Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $role
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Administrator extends Entity
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
        'first_name'            => true,
        'last_name'             => true,
        'password'              => true,
        'password_reset_token'  => true,
        'email'                 => true,
        'role'                  => true,
        'status'                => true,
        'created'               => true,
        'modified'              => true,
        'passkey'               => true,
        'timeout'               => true
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

    public function getRoleName()
    {
        $administratorsTable = TableRegistry::get('Administrators');
        $roles = $administratorsTable->getRoles();

        if(isset($roles[$this->role]))
            return $roles[$this->role];

        return "N/A";
    }

    public function getStatusName()
    {
        $administratorsTable = TableRegistry::get('Administrators');
        $statuses = $administratorsTable->getStatuses();

        if(isset($statuses[$this->status]))
            return $statuses[$this->status];

        return "N/A";
    }

    public function _getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
