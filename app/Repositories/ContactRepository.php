<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Dental\Contact;
use DentalSleepSolutions\Interfaces\Repositories\ContactInterface;

class ContactRepository extends BaseRepository implements ContactInterface
{
    /**
     * Main model name for the Contact Model
     *
     * @var string
     */
    protected $modelName = Contact::class;

    /**
     * Return all contacts
     * 
     * @param string $orderBy 
     * @param array $relations 
     * @return mixed
     */
    public function all($orderBy = 'contactid', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        return $instance->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    /**
     * Find a single item.
     * 
     * @param integer $id 
     * @param array $relations 
     * @return mixed
     */
    public function find($id, array $relations = [])
    {
        $relations = null;
        $model = $this->getModelName();
        $this->instance = $model::find($id);
        return $this->instance;
    }

    /**
     * Create a new contact
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
     * Update a contact
     * 
     * @param integer $id 
     * @param array $data 
     * @return object
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();
        $this->instance = parent::update($id, $data);
        return $this->instance;
    }
}
