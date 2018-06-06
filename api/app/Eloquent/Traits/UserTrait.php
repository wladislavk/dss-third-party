<?php

namespace DentalSleepSolutions\Eloquent\Traits;

trait UserTrait
{
    /**
     * @return int
     */
    public function normalizedDocId(): int
    {
        $docId = (int)$this->docid;
        if ($docId) {
            return $docId;
        }
        return (int)$this->userid;
    }

    /**
     * @return int
     */
    public function getUserIdOrZero()
    {
        if ($this->userid) {
            return $this->userid;
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
