<?php

namespace DentalSleepSolutions\Contracts\Resources;

/**
 * Contract ensuring easy to use active-record-like implementation
 * of the resource. Based on Eloquent for the devs convenience.
 */
interface Resource
{
    /**
     * Update resource.
     *
     * @param  array  $data
     * @return boolean
     */
    public function update(array $data = []);

    /**
     * Delete resource.
     *
     * @return boolean
     */
    public function delete();
}
