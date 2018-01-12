<?php
namespace App\Controllers;

use App\Controllers\ApiController;
use App\Repositories\NewsRepository;
use App\Controllers\helpers\NewsTraits;
class NewsController extends ApiController
{
    /*
     * Function Traits
     */
    use NewsTraits;

    public function initialize()
    {
        $this->repository = new NewsRepository();
    }

    public function storeAction()
    {
        $inputs = $this->postInput();

        $validate  = $this->validateApi($this->rulesCreate, [], $inputs);

        if (isset($validate['msgError'])) {
            return [400 => ['msgError' => $validate['msgError']] ];
        }

        $params['thumbnail']   = isset($inputs['thumbnail'])?$inputs['thumbnail']:"";
        $params['image']       = isset($inputs['image'])?$inputs['image']:"";
        $params['start_date']  = isset($inputs['start_date'])?$inputs['start_date']:"";
        $params['end_date']    = isset($inputs['end_date'])?$inputs['end_date']:"";
        $params['status']      = !empty($inputs['status'])?$inputs['status']:"inactive";
        $params['app_show']    = !empty($inputs['app_show'])?$inputs['app_show']:"customer";
        $params['name']        = isset($inputs['name'])?$inputs['name']:'';
        $params['detail']      = isset($inputs['detail'])?$inputs['detail']:'';
        $params['position']    = isset($inputs['position'])?$inputs['position']:0;
        $params['sent_status'] = isset($inputs['sent_status'])?$inputs['sent_status']:1;
        $params['sent_date']   = isset($inputs['sent_date'])?$inputs['sent_date']:null;

        $result = $this->repository->createRepo($params);

        if (!$result) {
            return [400 => ['msgError'=>'Create Error.']];
        }

        return $this->output(200, $result);
    }

    public function updateAction($id)
    {
        $inputs = $this->putInput();

        $validate  = $this->validateApi($this->rulesUpdate, [], $inputs);

        if (isset($validate['msgError'])) {
            return [400 => ['msgError' => $validate['msgError']] ];
        }

        //set condition
        $condition = [
            'conditions' => 'id =' . $id
        ];

        if (isset($inputs['thumbnail'])) {
            $params['thumbnail']   = $inputs['thumbnail'];
        }

        if (isset($inputs['image'])) {
            $params['image']   = $inputs['image'];
        }

        $params['start_date']  = isset($inputs['start_date'])?$inputs['start_date']:"";
        $params['end_date']    = isset($inputs['end_date'])?$inputs['end_date']:"";
        $params['status']      = !empty($inputs['status'])?$inputs['status']:"inactive";
        $params['app_show']    = !empty($inputs['app_show'])?$inputs['app_show']:"customer";
        $params['name']        = isset($inputs['name'])?$inputs['name']:'';
        $params['detail']      = isset($inputs['detail'])?$inputs['detail']:'';
        $params['position']    = isset($inputs['position'])?$inputs['position']:0;
        $params['sent_status'] = isset($inputs['sent_status'])?$inputs['sent_status']:1;
        $params['sent_date']   = isset($inputs['sent_date'])?$inputs['sent_date']:'';

        $result = $this->repository->updateRepo($condition , $params);

        if (empty($result)) {
            return [400 => ['msgError'=>'Update Error.']];
        }

        return $this->output(200, $params);
    }

    public function showAction($id)
    {
        //set condition
        $condition = [
            'conditions' => 'id = ' . $id
        ];

        $result = $this->repository->getById($condition);

        if (empty($result)) {
            return [400 => ['msgError'=>'Data Not Found']];
        }else{
            $result = count($result) ? $this->setDataDetail($result) : [];
        }

        return $this->output(200, $result);
    }

    /**
     * Show List
     * @return array (json)
     */
    public function datalistAction()
    {
        //get input
        $inputs = $this->getInput();

        $condition = " 1 ";

        $online = false;

        if (isset($inputs['online']) && $inputs['online'] == 'y') {
            $online = true;
        }

        unset($inputs['online']);

        //order my sql in dataList
        $sort   = $this->setSortDataListMySql($inputs);

        //search my sql in dataList
        $condition  .= $this->setWhereDataTableMySql($inputs);

        //custom where
        if ($online) {
         $condition  .= $this->setWhereOnline($inputs);
        }

        //repository
        $repository = $this->repository;

        $filter = [
            'conditions' => $condition,
            'offset'     => isset($inputs['offset']) ? $inputs['offset'] : 0,
            'limit'      => isset($inputs['limit']) ? $inputs['limit'] :10000,
            'order'      => $sort
        ];

        //get all data by condition
        $record   = $repository->getDataAll($filter);
        //get count all data
        $countAll = $repository->getCountAll([$condition]);

        if ($countAll == 0) {
            return [404 => ['msgError'=>'Data not Found']];
        }

        $output = [
            'recordsTotal'    => $countAll, //count all
            'recordsFiltered' => count($record), //count page
            // 'data'            => count($record) ? $record : []
            'data'            => count($record) ? $this->setDataList($record, $inputs) : []
        ];
        
        return $this->output(200, $output);
    }

    public function datalistallAction()
    {
        //get input
        $inputs = $this->getInput();

        $condition = " 1 ";
        //order my sql in dataList
        $sort   = $this->setSortDataListMySql($inputs);
        //search my sql in dataList
        $condition  .= $this->setWhereDataTableMySql($inputs);
        //repository
        $repository = $this->repository;

        $filter = [
            'conditions' => $condition,
            'skip'  => isset($inputs['offset']) ? $inputs['offset'] : 0,
            'limit' => isset($inputs['limit']) ? $inputs['limit'] :10000,
            'order'  => $sort
        ];

        if(!is_array($record)){
            return [400 => ['msgError'=>'Data Not Found']];
        }

        //get count all data
        $countAll = $repository->getCountAll([$condition]);

        $output = [
            'recordsTotal'    => $countAll, //count page
            'recordsFiltered' => count($record), //count all
            'data'            => count($record) ? $this->setDataList($record, $inputs) : []
        ];
        
        return $this->output(200, $output);
    }

    /**
     * Delete Data
     * @param string $id
     * @return array json (status = 200)
     */
    public function destroyAction($id)
    {
        // //set condition
        $condition = [
            'conditions' => 'id = ' . $id
        ];

        $result = [];

        // destroy
        $result = $this->repository->destroyRepo($condition);

        if (empty($result)) {
            return [400 => ['msgError'=>'Delete Error']];
        }

        return $this->output(200, $result);
    }

    /**
     * Delete Data
     * @param string $id
     * @return array json (status = 200)
     */
    public function softdestroyAction($id)
    {
        // //set condition
        // $condition = [
        //     'conditions' => "id = " . $id
        // ];

        // $params['status'] = 'deleted';

        // //delete
        // $result = $this->repository->softdestroyRepo($condition,$params);
        $result = [];

        if (empty($result)) {
            return [400 => ['msgError'=>'Delete Error.This service is not available.']];
        }

        return $this->output(200, $result);
    }

    /**
     * Delete Data Multi
     * @return array json (status = 200)
     */
    public function destroyMultiAction()
    {
        // //get input
        // $inputs = $this->postInput();

        // //set condition
        // $condition = [
        //     'conditions' => "id IN(".$this->getMultiIdMySql($inputs).")"
        // ];

        // $params['status'] = 'deleted';

        // //delete
        // $result = $this->repository->deleteRepo($condition,$params);
        $result = [];

        if (empty($result)) {
            return [400 => ['msgError'=>'Delete Error.This service is not available.']];
        }

        return $this->output(200, $result);
    }

    public function statusAction($id)
    {
        $inputs = $this->putInput();

        $validate  = $this->validateApi($this->rulesStatus, [], $inputs);

        if (isset($validate['msgError'])) {
            return [400 => ['msgError' => $validate['msgError']] ];
        }

        //set condition
        $condition = [
            'conditions' => 'id = ' . $id
        ];

        // get data
        $result = $this->repository->getById($condition);

        if (empty($result)) {
            return [400 => ['msgError'=>'Data Not Found']];
        }

        $params['status'] = $inputs['status'];

        //change status
        $result = $this->repository->statusRepo($condition, $params);

        if (empty($result)) {
            return [400 => ['msgError'=>'Update Status Error.']];
        }

        return $this->output(200, $params);
    }

}
