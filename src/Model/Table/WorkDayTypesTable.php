<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * WorkDayTypes Model
 *
 * @method \App\Model\Entity\WorkDayType get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkDayType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WorkDayType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkDayType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkDayType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkDayTypesTable extends Table
{
    private $checkInStatuses = [
        0 => 'Disabled',
        1 => 'Enabled'
    ];

    private $isDefaultStatuses = [
        0 => 'No',
        1 => 'Yes'
    ];

    private $isWeekendStatuses = [
        0 => 'No',
        1 => 'Yes'
    ];

    private $payedStatuses = [
        0 => 'No',
        1 => 'Yes'
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

        $this->setTable('work_day_types');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('code')
            ->maxLength('code', 1)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('check_in_enabled')
            ->allowEmptyString('check_in_enabled');

        $validator
            ->boolean('is_default')
            ->requirePresence('is_default', 'create')
            ->allowEmptyString('is_default');

        $validator
            ->boolean('is_weekend')
            ->allowEmpty('is_weekend');

        $validator
            ->scalar('color')
            ->requirePresence('color', 'create')
            ->notEmptyString('color');

        $validator
            ->boolean('payed')
            ->allowEmpty('payed');

        $validator->add('is_default', 'custom', [
            'rule' => function ($value, $context) 
            {
                if(Router::getRequest()->getParam('action') == 'edit')
                {
                    $workDayTypeDefault = $this->find()
                        ->where(['is_default' => true])
                        ->first();
                    
                    if($context['data']['id'] != $workDayTypeDefault['id'])
                    {
                        if($context['data']['is_default'] == 1)
                        {
                            $query = $this->query();
                            $query->update()
                                ->set(['is_default' => false])
                                ->where(['id' => $workDayTypeDefault['id']])
                                ->execute();
                        }
                    } else {

                        if($value == 0)
                            return false;
                    }

                    return true;
                }
            },
            'message' => __('You can not set the default work day type to false without selecting another one!')
        ]);

        return $validator;
    }

    public function getCheckInStatuses()
    {
        return $this->checkInStatuses;
    }

    public function getIsDefaultStatuses()
    {
        return $this->isDefaultStatuses;
    }

    public function getIsWeekendStatuses()
    {
        return $this->isWeekendStatuses;
    }

    public function getPayedStatuses()
    {
        return $this->payedStatuses;
    }

    public function beforeSave(Event $event, Entity $entity)
    {
        if(isset($entity['code']) && !empty($entity['code']))
            $entity['code'] = strtoupper($entity['code']);
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['code']));

        return $rules;
    }
}
