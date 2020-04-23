<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * WorkDayLogs Model
 *
 * @property \App\Model\Table\EmployeesTable|\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\WorkDayTypesTable|\Cake\ORM\Association\BelongsTo $WorkDayTypes
 *
 * @method \App\Model\Entity\WorkDayLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkDayLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WorkDayLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkDayLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkDayLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkDayLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkDayLogsTable extends Table
{
    private $autoLogged = [
        '0' => 'False',
        '1' => 'True'
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

        $this->setTable('work_day_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('WorkDayTypes', [
            'foreignKey' => 'work_day_type_id',
            'joinType' => 'INNER'
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
            ->date('work_day')
            ->requirePresence('work_day', 'create')
            ->notEmptyDate('work_day');

        $validator
            ->time('check_in_time')
            ->requirePresence('check_in_time', 'create')
            ->notEmptyTime('check_in_time');

        $validator
            ->time('check_out_time')
            ->requirePresence('check_out_time', 'create')
            ->notEmptyTime('check_out_time');

        $validator
            ->boolean('auto_logged');

        $validator
            ->integer('employee_id')
            ->notEmpty('employee_id');

        $validator
            ->integer('work_day_type_id')
            ->notEmpty('work_day_type_id');

        $validator->add('work_day', 'custom', [
            'rule' => function ($value, $context) 
            {
                $employeesTable = TableRegistry::get('Employees');
                
                $employee = $employeesTable->find()->where(['id' => $context['data']['employee_id'], 'contract_date <' => $value])->first();

                if($employee)
                    return true;

                return false;
            },
            'message' => __('Entered value must be greater than employees contract date!')
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['work_day_type_id'], 'WorkDayTypes'));

        return $rules;
    }

    public function getAutoLogged()
    {
        return $this->autoLogged;
    }
}
