<?php namespace Ds3\Admin\Contracts;


interface UserInterface {

    public function getAllUsers();

    public function getUserWithStatus($status);

    public function getUserByName($username);

    public function suspendUser($id);

    public function getUserById($id);

    public function updateUser($id);

    public function unSuspendUser($id);

    public function deleteUser($id);
} 