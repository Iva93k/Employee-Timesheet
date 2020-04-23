<?php
namespace App\Controller\Admin;

require ROOT.DS. 'vendor' .DS. 'phpoffice/phpspreadsheet/src/Bootstrap.php' ;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WorkDayLogs Controller
 *
 *
 * @method \App\Model\Entity\WorkDayLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WorkDayLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('title', __('List work day logs'));

        $filterMinYear = date('Y', strtotime('-5 years'));

        if($firstWorkDayLog = $this->WorkDayLogs->find()->select('work_day')->order(['work_day' => 'ASC'])->first())
            $filterMinYear = $firstWorkDayLog->work_day->format('Y');

        $conditions = [];

        $query = $this->WorkDayLogs->find('all', ['contain' => ['Employees', 'WorkDayTypes']]);

        $employeesTable = TableRegistry::get('Employees');
        $companiesTable = TableRegistry::get('Companies');
        $workDayTypesTable = TableRegistry::get('WorkDayTypes');

        $company = $companiesTable->find()->order(['id' => 'DESC'])->first();

        $employeesList = $employeesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'full_name'
        ])
        ->toArray();

        $workDayTypesList = $workDayTypesTable->find('list')->toArray();

        $queryParams = $this->request->getQueryParams();

        if(!empty($queryParams))
        {
            if(isset($queryParams['work_day_type_id']) && !empty($queryParams['work_day_type_id']))
                $conditions['work_day_type_id'] = $queryParams['work_day_type_id'];

            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']))
                $conditions['employee_id'] = $queryParams['employee_id'];

            if(isset($queryParams['day']['day']) && !empty($queryParams['day']['day']))
                $conditions['DAY(work_day)'] = $queryParams['day']['day'];

            if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
                $conditions['MONTH(work_day)'] = $queryParams['month']['month'];

            if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
                $conditions['YEAR(work_day)'] = $queryParams['year']['year'];

            if(isset($queryParams['auto_logged']) && !empty($queryParams['auto_logged']))
                $conditions['auto_logged'] = $queryParams['auto_logged'];
        }

        $query->where($conditions);

        $this->paginate = array(
           "order" => ["work_day DESC"],
           "limit" => count($employeesList) < 20 ? 20 : count($employeesList),
        );

        $workDayLogs = $this->paginate($query);

        $this->set(compact('workDayLogs', 'employeesList', 'workDayTypesList', 'filterMinYear', 'company'));
    }

    /**
     * View method
     *
     * @param string|null $id Work Day Log id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->set('title', __('View work day log'));

        $workDayLog = $this->WorkDayLogs->get($id, [
            'contain' => ['Employees', 'WorkDayTypes']
        ]);

        $this->set(compact('workDayLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->set('title', __('Add'));

        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $employeesTable = TableRegistry::get('Employees');
        $companiesTable = TableRegistry::get('Companies');

        $workDayTypesList = $workDayTypesTable->find('list')->toArray();

        $employeesList = $employeesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'full_name'
        ])
        ->where(['status'  => true])
        ->toArray();

        $company = $companiesTable->find()->order(['id' => 'DESC'])->first();

        $workDayLog = $this->WorkDayLogs->newEntity();

        $queryParams = $this->request->getQueryParams();
        
        if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']))
            $workDayLog->employee_id = $queryParams['employee_id'];

        if(isset($queryParams['work_day']) && !empty($queryParams['work_day']))
            $workDayLog->work_day = date($this->appConfData['dateFormat'], strtotime($queryParams['work_day']));

        if ($this->request->is('post'))
        {           
            $requestData = $this->request->getData();

            $date = date('Y-m-d', strtotime($requestData['work_day']));

            $workDayLogExist = $this->WorkDayLogs->find()
            ->where(['work_day' => $date, 'employee_id' => $requestData['employee_id']])
            ->first();

            if($workDayLogExist) {
                $this->Flash->error(__('The work day log already exists!'));
            } else {

                if(isset($requestData['work_day']))
                    $requestData['work_day'] = date('Y-m-d', strtotime($this->request->getData('work_day')));

                if(isset($requestData['check_in_time']))
                    $requestData['check_in_time'] = date('H:i', strtotime($this->request->getData('check_in_time')));

                if(isset($requestData['check_out_time']))
                    $requestData['check_out_time'] = date('H:i', strtotime($this->request->getData('check_out_time')));

                $workDayLog->auto_logged = false;
                
                $workDayLog = $this->WorkDayLogs->patchEntity($workDayLog, $requestData);

                if ($this->WorkDayLogs->save($workDayLog))
                {
                    $this->Flash->success(__('The work day log has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->error(__('The work day log could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('workDayLog', 'workDayTypesList', 'employeesList', 'company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Day Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->set('title', __('Edit'));

        $workDayTypesTable = TableRegistry::get('WorkDayTypes');
        $employeesTable = TableRegistry::get('Employees');
        $companiesTable = TableRegistry::get('Companies');

        $workDayTypesList = $workDayTypesTable->find('list')->toArray();

        $employeesList = $employeesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'full_name'
        ])->toArray();

        $company = $companiesTable->find()->order(['id' => 'DESC'])->first();

        $workDayLog = $this->WorkDayLogs->get($id, [
            'contain' => ['WorkDayTypes', 'Employees']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) 
        {
            $requestData = $this->request->getData();

            if(isset($requestData['work_day']))
                $requestData['work_day'] = date('Y-m-d', strtotime($this->request->getData('work_day')));

            if(isset($requestData['check_in_time']))
                $requestData['check_in_time'] = date('H:i', strtotime($this->request->getData('check_in_time')));

            if(isset($requestData['check_out_time']))
                $requestData['check_out_time'] = date('H:i', strtotime($this->request->getData('check_out_time')));

            $workDayLog->auto_logged = false;
            
            $workDayLog = $this->WorkDayLogs->patchEntity($workDayLog, $requestData);

            if ($this->WorkDayLogs->save($workDayLog)) 
            {
                $this->Flash->success(__('The work day log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The work day log could not be saved. Please, try again.'));
        }

        if(is_object($workDayLog->check_in_time))
            $workDayLog->check_in_time = $workDayLog->check_in_time->format('H:i');

        if(is_object($workDayLog->check_out_time))
            $workDayLog->check_out_time = $workDayLog->check_out_time->format('H:i');

        $this->set(compact('workDayLog', 'workDayTypesList', 'employeesList', 'company'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Day Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workDayLog = $this->WorkDayLogs->get($id);
        if ($this->WorkDayLogs->delete($workDayLog)) {
            $this->Flash->success(__('The work day log has been deleted.'));
        } else {
            $this->Flash->error(__('The work day log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function preview()
    {
        $this->set('title', __('Preview'));

        $queryParams = $this->request->getQueryParams();

        $query = $this->WorkDayLogs->find('all', ['contain' => ['Employees', 'WorkDayTypes']]);

        $conditions = ['MONTH(work_day)' => date('m'), 'YEAR(work_day)' => date('Y')];

        if(!empty($queryParams))
        {
            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']))
                $conditions['employee_id'] = $queryParams['employee_id'];

            if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
                $conditions['MONTH(work_day)'] = $queryParams['month']['month'];

            if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
                $conditions['YEAR(work_day)'] = $queryParams['year']['year'];
        }

        $workDayLogs = $query->where($conditions)->toArray();

        $preparedData = [];
        foreach ($workDayLogs as $wdl)
        {
            $preparedData[$wdl->employee_id][(int)$wdl->work_day->format('d')] = [
                'wdtID' => $wdl->work_day_type_id, 
                'wdlID' => $wdl->id
            ]; 
        }
        
        $filterMinYear = date('Y', strtotime('-5 years'));

        if($firstWorkDayLog = $this->WorkDayLogs->find()->select('work_day')->order(['work_day' => 'ASC'])->first())
            $filterMinYear = $firstWorkDayLog->work_day->format('Y');

        $employeesTable = TableRegistry::get('Employees');
        $employees = $employeesTable->find()
            ->select(['id', 'first_name', 'last_name', 'status'])
            ->toArray();

        $employeesList = [];
        foreach ($employees as $keyEmployee => $employee) 
        {
            if(!isset($preparedData[$employee->id]))
            {
                unset($employees[$keyEmployee]);
                continue;
            }

            $employeesList[$employee->id] = $employee->full_name;
        }

        $workDayTypesTable = TableRegistry::get('WorkDayTypes');

        $workDayTypes = $workDayTypesTable->find()->toArray();
        $workDayTypesList = $workDayTypesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'code'
        ])->toArray();

        $workDayTypesColors = $workDayTypesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'color'
        ])->toArray();

        $this->set(compact('workDayLogs', 'employees', 'employeesList', 'filterMinYear', 'workDayTypesList', 'preparedData', 'queryParams', 'workDayTypes', 'workDayTypesColors'));
    } 

    public function exportExcelfile()
    {
        /*$alphasAZ = range('A', 'Z');
        $alphasAAZZ = [];

        $alphasColumns = [];
        foreach ($alphasAZ as $char1) 
        {
            $alphasColumns[] = $char1;
            foreach ($alphasAZ as $char2)
                $alphasAAZZ[] = $char1 . $char2;
        }

        foreach ($alphasAAZZ as $char2)
            $alphasColumns[] = $char2;*/
        $companiesTable = TableRegistry::get('Companies');
        $company = $companiesTable->find()->order(['id' => 'DESC'])->first();

        $spreadsheet = new Spreadsheet();

        $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
        $richText->createText('');
        $companyDetails = $richText->createTextRun($company->name);
        $companyDetails->getFont()->setBold(true);
        $companyDetails->getFont()->setItalic(true);
        $richText->createText("\n" . $company->address);

        $spreadsheet ->getProperties()
            ->setCreator('Employee timesheet')
            ->setLastModifiedBy('Employee timesheet')
            ->setTitle('Employee timesheet')
            ->setSubject('Employee timesheet')
            ->setDescription('Employee timesheet')
            ->setKeywords('Employee timesheet')
            ->setCategory('Employee timesheet');

        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', $richText)
            ->setCellValue('B3', 'MJESEČNI FOND SATI')
            ->setCellValue('AH3', "Ukupno\nsati")
            ->setCellValue('AI3', "Ukupno\nDNEVNI RAD")
            ->setCellValue('AJ3', "DRŽAVNI ILI\nVJERSKI\nPRAZNIK")
            ->setCellValue('AK3', 'RAD OD KUĆE')
            ->setCellValue('AL3', 'BOLOVANJE')
            ->setCellValue('AM3', 'SLOBODNI DANI')
            ->setCellValue('AN3', "SLUŽBENO\nPUTOVANJE")
            ->setCellValue('AO3', "PORODILJSKO\nBOLOVANJE")
            ->setCellValue('A4', 'R/B')
            ->setCellValue('B4', 'Prezime i ime radnika');

        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(30);         
        $spreadsheet->getActiveSheet()->getStyle('A1:AO3')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->mergeCells('A1:AO1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:AO2');
        $spreadsheet->getActiveSheet()->mergeCells('B3:AG3');


        /*$usedAlphasColumns = [
            'AH'    => true,
            'C'     => 3
        ];

        foreach ($usedAlphasColumns as $columnLetter => $size)
        {
            if($size !== true)
                $spreadsheet->getActiveSheet()->getColumnDimension($columnLetter)->setWidth($size);
            else
                $spreadsheet->getActiveSheet()->getColumnDimension($columnLetter)->setAutoSize($size);
        }*/

        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AN')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setWidth(3);

        /*$spreadsheet->getDefaultStyle()->getFont()->setSize(8);       
        $spreadsheet->getActiveSheet()->getStyle('A2:AO2')->getFont()->setSize(8);*/
        
        $spreadsheet->getActiveSheet()->getStyle('A1:AO1')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A3:AO3')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A3:AO3')
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:AO4')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A4:B4')->getFont()->setBold(true);
        
        $spreadsheet->getActiveSheet()->getStyle('A3:AO3')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('eeeeee');

        $spreadsheet->getActiveSheet()->getStyle('A1:AO1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('eeeeee');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $queryParams = $this->request->getQueryParams();

        $query = $this->WorkDayLogs->find('all', ['contain' => ['Employees', 'WorkDayTypes']]);

        $conditions = ['MONTH(work_day)' => date('m'), 'YEAR(work_day)' => date('Y')];

        if(!empty($queryParams))
        {
            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']))
                $conditions['employee_id'] = $queryParams['employee_id'];

            if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
                $conditions['MONTH(work_day)'] = $queryParams['month']['month'];

            if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
                $conditions['YEAR(work_day)'] = $queryParams['year']['year'];
        }

        $workDayLogs = $query->where($conditions)->toArray();


        $preparedData = [];
        foreach ($workDayLogs as $wdl)
        {
            $preparedData[$wdl->employee_id][(int)$wdl->work_day->format('d')] = [
                'wdtID' => $wdl->work_day_type_id, 
                'wdlID' => $wdl->id
            ]; 
        }
        
        $filterMinYear = date('Y', strtotime('-5 years'));

        if($firstWorkDayLog = $this->WorkDayLogs->find()->select('work_day')->order(['work_day' => 'ASC'])->first())
            $filterMinYear = $firstWorkDayLog->work_day->format('Y');

        $employeesTable = TableRegistry::get('Employees');

        $employees = $employeesTable->find()
            ->select(['id', 'first_name', 'last_name', 'status'])
            ->toArray();

        $employeesList = [];
        foreach ($employees as $keyEmployee => $employee) 
        {
            if(!isset($preparedData[$employee->id]))
            {
                unset($employees[$keyEmployee]);
                continue;
            }

            $employeesList[$employee->id] = $employee->full_name;
        }

        $workDayTypesTable = TableRegistry::get('WorkDayTypes');

        $workDayTypes = $workDayTypesTable->find()->toArray();
        $workDayTypesList = $workDayTypesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'code'
        ])->toArray();

        $workDayTypesColors = $workDayTypesTable->find('list', [
            'keyField'  => 'id',
            'valueField'=> 'color'
        ])->toArray();

        $year = date('Y');
        if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
            $year = $queryParams['year']['year'];

        $month = date('m');
        if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
            $month = $queryParams['month']['month'];

        $monthDays = cal_days_in_month(CAL_GREGORIAN , $month , $year);

        for ($i=3; $i<=$monthDays+2; $i++)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($i, 4, $i-2);   
        }

        $i = 5;
        foreach ($employees as $employee)
        {
            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']) && $queryParams['employee_id'] != $employee->id)
                continue;
            
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $i-4);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $employee->full_name);

            $spreadsheet->getActiveSheet()->getStyle('A1:AO'.$i)->applyFromArray($styleArray);

            $spreadsheet->getActiveSheet()->getStyle('C5:AG'.$i)
                        ->getAlignment()
                        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            for ($dayInMonth=1; $dayInMonth <= $monthDays; $dayInMonth++)
            {
                if(isset($preparedData[$employee->id]) && isset($preparedData[$employee->id][$dayInMonth]))
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($dayInMonth+2, $i, $workDayTypesList[$preparedData[$employee->id][$dayInMonth]['wdtID']]); 
                else
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($dayInMonth+2, $i, ''); 
            }  
            $i++;
        }

        $spreadsheet->getActiveSheet()->mergeCells('AE'.$i.':AG'.$i);
        $spreadsheet->getActiveSheet()->getStyle('AE'.$i.':AO'.$i)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(31, $i, 'Ukupno:');

        foreach ($workDayTypes as $wdt) 
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $i+2, $wdt->code . ' - ' . $wdt->title);
            $i++;
        }   

        $writer = new Xlsx($spreadsheet);

        $year = date('Y');
        $month = date ('m');
        $employeeFullName = '';
        $filename = '';

        if(!empty($queryParams))
        {
            if(isset($queryParams['employee_id']) && !empty($queryParams['employee_id']))
            {
                $employee = $employeesTable->find()->select('id')->where(['id' => $queryParams['employee_id']])->first();
                $employeeID = $employee->id;
                $filename .= $employeeID . '_';
            }

            if(isset($queryParams['month']['month']) && !empty($queryParams['month']['month']))
                $month = $queryParams['month']['month'];

            if(isset($queryParams['year']['year']) && !empty($queryParams['year']['year']))
                $year = $queryParams['year']['year'];
        }

        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Mjesec: \n" . $month);

        $filename .= $month . '_' . $year . '.xlsx';

        $writer->save(WWW_ROOT . DS . 'files' . DS . $filename);

        $response = $this->response->withFile(
            WWW_ROOT . DS. 'files' . DS . $filename,
            ['download' => true, 'name' => $filename]
        );

        return $response;

    }
}
