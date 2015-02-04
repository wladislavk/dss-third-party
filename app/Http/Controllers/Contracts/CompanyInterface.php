<?php namespace Ds3\Contracts;

interface CompanyInterface
{
	public function get();

	public function getLogo($userId);

	public function getBilling($where, $order = null);

	public function getJoin($userId, $companyType);

	public function getCo($userId);
}