<?php
namespace Ds3\Admin\Repositories;

use Ds3\Admin\Contracts\PlanInterface;
use Ds3\Eloquent\Plan;

class PlanRepository implements PlanInterface
{
    private $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function all()
    {
       return $this->plan->active()->paginate(20);
    }

    public function save($fields)
    {
        if ($this->plan->create($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function find($id)
    {
        return $this->plan->find($id);
    }

    public function update($id, $fields)
    {
        if ($this->plan->find($id)->update($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id){}
}
