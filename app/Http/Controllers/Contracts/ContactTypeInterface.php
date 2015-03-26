<?php
namespace Ds3\Contracts;

interface ContactTypeInterface
{
    public function find($contactTypeId);
    public function getPhysicians();
    public function getContactTypes();
    public function getAll();
}
