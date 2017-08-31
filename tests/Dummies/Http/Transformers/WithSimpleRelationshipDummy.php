<?php

namespace Tests\Dummies\Http\Transformers;

use DentalSleepSolutions\Contracts\SimpleRelationshipInterface;
use DentalSleepSolutions\Http\Transformers\WithSimpleRelationship;

class WithSimpleRelationshipDummy implements SimpleRelationshipInterface
{
    use WithSimpleRelationship;

    const SIMPLE_MAP = [
        'external_representation.first.anything',
        'external_representation.first.company_name' => 'internal_representation.company',
        'external_representation.first.address1' => 'internal_representation.address',
        'external_representation.second.lastname' => 'internal_representation.name.last',
        'external_representation.second.middlename' => 'internal_representation.name.middle',
        'external_representation.second.firstname' => 'internal_representation.name.first',
        'external_representation.second.title' => 'internal_representation.title',
    ];
}
