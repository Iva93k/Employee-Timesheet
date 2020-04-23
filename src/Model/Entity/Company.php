<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $phone_number
 * @property string $fax
 * @property string $email
 * @property string $web
 * @property string $contact_person
 * @property string $id_number
 * @property string $tax_number
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Company extends Entity
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
        'name'              => true,
        'address'           => true,
        'city'              => true,
        'phone_number'      => true,
        'fax'               => true,
        'email'             => true,
        'web'               => true,
        'contact_person'    => true,
        'id_number'         => true,
        'tax_number'        => true,
        'lunch_break'       => true,
        'start_working_time'=> true,
        'end_working_time'  => true,
        'created'           => true,
        'modified'          => true
    ];
}
