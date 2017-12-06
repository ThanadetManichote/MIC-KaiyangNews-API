<?php
namespace App\Repositories;

use App\Models\News;
use App\Repositories\BaseRepository;

class NewsRepository extends BaseRepository {

    private $nameClass = 'News';

    /**
     * Show List
     * @param array $condition
     * @return array (default [])
     */
    public function getDataAll(array $condition = [])
    {
        return $this->getFind($this->nameClass, $condition);
    }

    /**
     * Get count record mongo
     * @param array $condition
     * @return int (default 0)
     */
    public function getCountAll(array $condition = [])
    {
        return $this->countRecord($this->nameClass, $condition);
    }

    /**
     * Show
     * @param array $condition
     * @return array (default [])
     */
    public function getById(array $condition = [])
    {
        return $this->getFindFirst($this->nameClass, $condition);
    }

    /**
     * Create
     * @param array $params
     */
    public function createRepo(array $params)
    {
        return $this->create($this->nameClass, $params);
    }

    /**
     * Update
     * @param array $condition, array $params
     */
    public function updateRepo(array $condition, array $params)
    {
        return $this->update($this->nameClass, $condition, $params);
    }

    /**
     * Soft Delete
     * @param array $condition, array $params
     */
    public function softdestroyRepo(array $condition, array $params)
    {
        return $this->update($this->nameClass, $condition, $params);
    }

    /**
     * Destroy
     * @param array $condition, array $params
     */
    public function destroyRepo(array $condition)
    {
        return $this->destroy($this->nameClass, $condition);
    }

    /**
     * Status
     * @param array $condition, array $params
     */
    public function statusRepo(array $condition, array $params)
    {
        return $this->update($this->nameClass, $condition, $params);
    }


}
