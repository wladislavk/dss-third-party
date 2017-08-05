<?php

namespace DentalSleepSolutions\Eloquent\Traits;

trait UserTrait
{
    /**
     * @return int
     */
    public function getDocIdOrZero()
    {
        if ($this->docid) {
            return $this->docid;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getUserIdOrZero()
    {
        // TODO: there is no ID field by default on this model
        if (property_exists($this, 'id') && $this->id) {
            return $this->id;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getUserTypeOrZero()
    {
        if ($this->user_type) {
            return $this->user_type;
        }
        return 0;
    }
}
