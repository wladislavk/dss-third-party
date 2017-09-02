<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCases\ApiTestCase;

class ExternalUsersApiTest extends ApiTestCase
{
    const ENDPOINT = '/api/v1/external-user';

    protected function getModel()
    {
        return ExternalUser::class;
    }

    protected function getRoute()
    {
        return '/external-user';
    }

    protected function getModelKey()
    {
        return 'user_id';
    }

    protected function getStoreData()
    {
        $user = factory(User::class)->create();
        $externalUser = parent::getStoreData();
        $externalUser[$this->getModelKey()] = $user->userid;
        unset($externalUser['created_by']);
        unset($externalUser['updated_by']);

        return $externalUser;
    }

    protected function getUpdateData()
    {
        return [
            'api_key' => $this->faker->sha1,
        ];
    }

    protected function modelFactory($count = 1)
    {
        // OneToOne dependency
        $user = factory(User::class)->create();
        $userId = $user->userid;

        if ($count === 1) {
            return factory($this->getModel())->create([
                $this->getModelKey() => $userId
            ]);
        }

        $collection = [];

        for ($n = 0; $n < $count; $n++) {
            $collection[] = factory($this->getModel())->create([
                $this->getModelKey() => $userId + $n
            ]);
        }

        return new Collection($collection);
    }
}
