<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 7/23/2015
 * Time: 2:45 PM
 */

namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\MemoAdminInterface;

class MemoAdminRepository extends BaseRepository implements MemoAdminInterface
{

    protected $modelName = 'DentalSleepSolutions\MemoAdmin';

    /**
     * Return all memos
     *
     * @param int $orderBy
     * @param array $relations
     * @return mixed
     */
    public function all($orderBy = 'memo_id', $relations = [])
    {
        throw new \BadMethodCallException('Must implement.');
    }

    /**
     * Paginate items
     *
     * @param string $orderBy
     * @param array $relations
     * @param int $paginate
     * @param array $params
     * @return mixed
     */
    public function paginate($orderBy = 'memo', $relations = [], $paginate = 50, $params = [])
    {
        throw new \BadMethodCallException('Must implement.');
    }

    /**
     * Get all items by a field
     *
     * @param $field
     * @param $value
     * @param $relations
     * @return mixed
     */
    public function getBy($field, $value, $relations = [])
    {
        throw new \BadMethodCallException('Must implement.');
    }

    /**
     * List all memos - primarily used for drop downs...
     *
     * @param string $fieldName
     * @param string $fieldId
     * @return mixed
     */
    public function lists($fieldName = 'memo', $fieldId = 'memo_id')
    {
        throw new \BadMethodCallException('Must implement.');
    }

    /**
     * Find a single item
     *
     * @param $memo_id
     * @param $relations
     * @return mixed
     */
    public function find($memo_id, $relations = [])
    {
        $model = $this->getModelName();

        $this->instance = $model::find($memo_id);

        return $this->instance;
    }

    /**
     * Create new memo
     *
     * @param array $data
     * @return object
     */
    public function store($data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::store($data);

        return $this->instance;
    }

    /**
     * Update memo
     *
     * @param int $id
     * @param array $data
     * @return object
     */
    public function update($id, $data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::update($id, $data);

        return $this->instance;
    }

}