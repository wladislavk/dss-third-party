<?php namespace DentalSleepSolutions\Interfaces;

interface BaseInterface
{
    /**
     * Return all items
     *
     * @param string $orderBy
     * @param array  $relations
     * @return mixed
     */
    public function all($orderBy = 'id', array $relations = []);

    /**
     * Paginate items
     *
     * @param string  $orderBy
     * @param array   $relations
     * @param integer $paginate
     * @param array   $parameters
     * @return mixed
     */
    public function paginate($orderBy = 'name', array $relations = [], $paginate = 50, array $parameters = []);

    /**
     * Get all items by a field
     *
     * @param string $field
     * @param string $value
     * @param array  $relations
     * @return mixed
     */
    public function getBy($field, $value, array $relations = []);

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
     * @param integer $id
     * @param array   $relations
     * @return mixed
     */
    public function find($id, array $relations = []);

    /**
     * Find a single item by a field
     *
     * @param string $field
     * @param string $value
     * @param array  $relations
     * @return mixed
     */
    public function findBy($field, $value, array $relations = []);

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
    public function store(array $data = null);

    /**
     * Update an existing item
     *
     * @param integer $id
     * @param array   $data
     * @return mixed
     */
    public function update($id, array $data = null);

    /**
     * Permanently remove an item from storage
     *
     * @param integer $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * Checks whether the model has any errors
     *
     * @return boolean
     */
    public function hasErrors();

    /**
     * Returns model validation error messages
     *
     * @return array
     */
    public function getErrors();
}
