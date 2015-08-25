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

    /**
     *
     * @var string
     *
     * Main model name for the Memos Model
     */
    protected $modelName = 'DentalSleepSolutions\MemoAdmin';


    /**
     *
     * Return all memos
     *
     * @param string $orderBy
     * @param array  $relations
     * @return mixed
     */
    public function all($orderBy = 'memo_id', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        return $instance->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    /**
     *
     * Paginate items
     *
     * @param string  $orderBy
     * @param array   $relations
     * @param integer $paginate
     * @param array   $params
     * @return mixed
     */
    public function paginate($orderBy = 'memo', array $relations = [], $paginate = 50, array $params = [])
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
     *
     * Find a single item.
     *
     * @param integer $memo_id
     * @param array   $relations
     * @return mixed
     */
    public function find($memo_id, array $relations = [])
    {
        $relations = null;

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
    public function store(array $data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::store($data);

        return $this->instance;
    }

    /**
     * Update memo
     *
     * @param integer $id
     * @param array   $data
     * @return object
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();

        $this->instance = parent::update($id, $data);

        return $this->instance;
    }
}
