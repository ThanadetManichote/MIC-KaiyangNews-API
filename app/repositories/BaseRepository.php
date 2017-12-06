<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class BaseRepository extends \Phalcon\Mvc\Micro
{
    public function __constuctor()
    {
        $this->client  = new Client();
    }

    /**
     * Get model name
     */
    private function getModelName($name)
    {
        $className = "\\App\\Models\\{$name}";

        if (!class_exists($className)) {
            return false;
        }

        return new $className();
    }

    /**
     * Count mongo
     * @param string $nameModel, array $condition
     */
    protected function countRecord($nameModel, array $condition = [])
    {
        try {
            return $this->getModelName($nameModel)->count($condition);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get by findFirst
     * @param string $nameModel, array $condition
     */
    protected function getFindFirst($nameModel, array $condition = [])
    {
        //define datas
        $datas = [];

        try {

            $model = $this->getModelName($nameModel)->findFirst($condition);

            if ($model) {
                $datas = $this->setToArray($model);
            }

            return $datas;

        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * Get by find
     * @param string $nameModel, array $condition
     */
    protected function getFind($nameModel, array $condition = [])
    {
        //define datas
        $datas = [];

        try {

            $model = $this->getModelName($nameModel)->find($condition);

            if ($model) {
                foreach ($model as $row) {
                    $datas[] = $this->setToArray($row);
                }
            }

            return $datas;

        } catch (\Exception $e) {

            return false;
        }
    }

    /**
     * Create Data
     * @param string $nameModel, array $params
     */
    protected function create($nameModel, array $params)
    {
        $data = [];

        try {

            $model = $this->getModelName($nameModel);

            if ($model) {

                //set field and value
                foreach ($params as $kData => $vData) {
                    $model->{$kData} = trim($vData);
                }

                if ($model->save()) {
                    $data =  $this->setToArray($model);
                }
            }

            return $data;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update Data
     * @param string $nameModel, array $condition, array $params
     */
    protected function update($nameModel, array $condition, array $params)
    {
        $data = [];

        try {

            $model = $this->getModelName($nameModel)->findFirst($condition);

            if ($model) {

                //set field and value
                foreach ($params as $kData => $vData) {
                    $model->{$kData} = trim($vData);
                }

                if ($model->save()) {
                    return $this->setToArray($model);
                }
            }

            return $data;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Delete Data
     * @param string $nameModel, array $condition, array $params
     */
    protected function destroy($nameModel, array $condition)
    {
        $result = [];

        try {

            $model = $this->getModelName($nameModel)->findFirst($condition);

            if ($model) {
                $array = $this->setToArray($model);
                if ($model->delete()) {
                    $result = $array;
                }
            }

            return $result;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Set toArray data
     * @param object $model
     */
    protected function setToArray($model)
    {
        $toArray = $model->toArray();
        // convert mongo
        if(isset($toArray['_id'])){
            $mongoId = [ 'id' => (string) $toArray['_id'] ];
            unset($toArray['_id']);
            $toArray = array_merge($mongoId, $toArray);
        }

        return $toArray;
    }

    protected function curl($url, $method, $params) {

        try {
            $client = new Client(['base_uri' => $url]);

            $res    = $client->request($method, '', $params);
            $result = $res->getBody();

            return json_decode($result, true);

        } catch (\Exception $e) {
            exit('Process Not Working');
            $msg['0'] = 'Uh oh! ' . $e->getMessage();
            $msg['1'] = 'HTTP request URL: ' . $e->getRequest()->getUrl();
            $msg['2'] = 'HTTP request: ' . $e->getRequest();
            $msg['3'] = 'HTTP response status: ' . $e->getResponse()->getStatusCode();
            $msg['4'] = 'HTTP response: ' . $e->getResponse();

            return $error['error_curl_ms'] = $msg;
        }

    }
}
