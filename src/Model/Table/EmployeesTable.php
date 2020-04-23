<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeesTable extends Table
{
    private $statuses = [
        0 => 'Inactive',
        1 => 'Active'
    ];

    private $uidAccess = [
        0 => 'False',
        1 => 'True'
    ];

    private $gender = [
        0 => 'Male',
        1 => 'Female'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('employees');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Proffer.Proffer', [
            'photo_name' => [    // The name of your upload field
                'root' => WWW_ROOT . 'files', // Customise the root upload folder here, or omit to use the default
                'dir' => 'photo_path',   // The name of the field to store the folder
                'thumbnailSizes' => [ // Declare your thumbnails
                    'small' => [   // Define the prefix of your thumbnail
                        'w'             => 150, // Width
                        'h'             => 200, // Height
                        'jpeg_quality'  => 100
                    ],
                    'medium' => [     // Define a second thumbnail
                        'w'             => 480,
                        'h'             => 640,
                        'jpeg_quality'  => 100
                    ]
                ],
                'thumbnailMethod' => 'gd'   // Options are Imagick or Gd
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', __("Required"), 'create');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 255)
            ->allowEmptyString('avatar');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->minLength('password', 4, __('Password is too short! 4 characters are required!'))
            ->maxLength('password', 50)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 100)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        $validator
            ->date('birthdate')
            //->requirePresence('birthdate', 'create')
            ->allowEmptyDate('birthdate');

        $validator
            ->date('contract_date')
            //->requirePresence('contract_date', 'create')
            ->allowEmptyDate('contract_date');

        $validator
            ->scalar('uid')
            ->requirePresence('uid', 'create')
            ->allowEmptyString('uid');

        $validator
            ->boolean('allow_uid_access')
            ->requirePresence('allow_uid_access', 'create')
            ->allowEmptyString('allow_uid_access');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

         $validator
            ->integer('gender')
            ->notEmptyString('gender');

        $validator
            ->allowEmpty('photo_name');

        $validator->add('photo_name', 'type', [
            'rule' => function ($value, $context) 
            {
                if ($value['name'] != '') 
                {
                    $type = $value['type'];
                    $allowedTypes = ['image/png', 'image/gif', 'image/jpeg'];

                    if (in_array($type, $allowedTypes)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            },
            'message' => 'Allowed image types are: png, jpeg and gif.'
        ]);

        $validator->add('photo_name', 'size', [
            'rule' => function ($value, $context) 
            {
                if ($value['name'] != '') 
                {
                    if ($value['size'] <= 1048576) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            },
            'message' => 'Max allowed image size is 1MB.'
        ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function getStatuses()
    {
        return $this->statuses;
    }

    public function getUidAccess()
    {
        return $this->uidAccess;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public static function randomPassword() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; 
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) 
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        
        return implode($pass);
    }
}
