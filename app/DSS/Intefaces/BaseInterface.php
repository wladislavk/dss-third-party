<?php namespace DentalSleepSolutions\Interfaces;

interface BaseInterface
{
    /**
     * Return all items
     *
     * @param int $orderBy
     * @param array $relations
     * @return mixed
     */
    public function all($orderBy = 'id', $relations = []);

    /**
     * Paginate items
     *
     * @param string $orderBy
     * @param array $relations
     * @param int $paginate
     * @param array $parameters
     * @return mixed
     */
    public function paginate($orderBy = 'name', $relations = [], $paginate = 50, $parameters = []);

    /**
     * Get all items by a field
     *
     * @param $field
     * @param $value
     * @param $relations
     * @return mixed
     */
    public function getBy($field, $value, $relations = []);

    /**
     * List all items
     *
     * @param string $fieldName
     * @param string $fieldId
     * @return mixed
     */
    public function lists($fieldName = 'name', $fieldId = 'id');

    /**
     * Find a single item
     *
     * @param $id
     * @param $relations
     * @return mixed
     */
    public function find($id, $relations = []);

    /**
     * Find a single item by a field
     *
     * @param $field
     * @param $value
     * @param $relations
     * @return mixed
     */
    public function findBy($field, $value, $relations = []);

    /**
     * Find a single record by multiple fields
     *
     * @param array $data
     * @param array $relations
     * @return mixed
     */
    public function findByMany(array $data, array $relations = []);

    /**
     * Store a newly created item
     *
     * @param array $data
     * @return mixed
     */
    public function store($data = null);

    /**
     * Update an existing item
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, $data = null);

    /**
     * Permanently remove an item from storage
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * Checks whether the model has any errors
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Returns model validation error messages
     *
     * @return array
     */
    public function getErrors();
}
