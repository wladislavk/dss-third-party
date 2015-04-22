<?php
namespace Ds3\Ds3Auth;

interface Ds3AuthInterface
{
    public function getByUsername($username, $model);
    public function recoverAndSetHash($id, $email, $model, $columnName);
    public function getUserSalt($username, $model);
    public function generatePassword($password, $salt);
    public function attempt($username, $passwords);
}
