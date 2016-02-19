<?php

namespace DentalSleepSolutions\Eloquent;

trait WithoutCreatedTimestamp
{
    /**
     * Don't set the value of the "created at" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setCreatedAt($value)
    {
        return $this;
    }

    /**
     * Get the name of the "created at" column.
     *
     * @return string
     */
    public function getCreatedAtColumn()
    {
        return null;
    }
}