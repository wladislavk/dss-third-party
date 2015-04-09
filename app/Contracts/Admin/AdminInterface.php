<?php
namespace Ds3\Admin\Contracts;

interface AdminInterface
{
    public function getByUsername($username);
    public function recoverAndSetHash($admin_id,$email);
    public function attemptAuth($username,$password);
    public function getSupportAdmins($categoryId);
    public function findAdmin($adminId);
}
