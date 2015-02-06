<?php namespace Ds3\Admin\Contracts;


interface UserInterface {

    public function getAllUsers();

    public function getUserWithStatus($status);

    public function suspendUser($id);

    public function findUser($id);

    public function updateUser($id);

    public function unSuspendUser($id);

    public function deleteUser($id);

    public function getCompanies($companyType);

    public function getUserType();

    public function getAccessCode();

    public function getUserPlansWithStatus($planType);

    public function getAllUserPlans();
}

