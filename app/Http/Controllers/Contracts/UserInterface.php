<?php
namespace Ds3\Contracts;

interface UserInterface
{
    public function attemptAuth($username, $hashPassword);
    public function getType($docId);
    public function findUser($userId);
    public function getCourseJoin($userId);
    public function getProviderSelect($docId);
    public function getProducerOptions($docId);
    public function getCheck($username, $password, $docId);
    public function getLocation($where, $defaultLocation = null);
    public function isUniqueField($field, $userId);
    public function getResponsible($userId, $docId);
    public function updateData($userId, $values);
    public function insertData($data);
}
