<?php
/**
 * Created by PhpStorm.
 * User: saqib
 * Date: 2/5/15
 * Time: 2:07 PM
 */

namespace Ds3\Admin\Contracts;


interface AccessCodeInterface {

    public function save($fields);

    public function update($fields,$id);

    public function find($id);

    public function getAllAccessCodes();

} 