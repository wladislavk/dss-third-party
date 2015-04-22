<?php
namespace Ds3\Contracts;

interface CompanyInterface
{
    public function getAll();
    public function getLogo($userId);
    public function getBilling($where, $order = null);
    public function getJoin($userId, $companyType);
    public function getCompanyJoinUser($userId);
}
