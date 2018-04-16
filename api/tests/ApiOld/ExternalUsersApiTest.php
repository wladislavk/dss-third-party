<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCases\ModelAwareApiTestCase;

class ExternalUsersApiTest extends ModelAwareApiTestCase
{
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
        if ($count === 1) {
            $user = factory(User::class)->create();
            return factory($this->getModel())->create([
                $this->getModelKey() => $user->userid
            ]);
        }

        $collection = [];

        for ($n = 0; $n < $count; $n++) {
            $user = factory(User::class)->create();
            $collection[] = factory($this->getModel())->create([
                $this->getModelKey() => $user->userid
            ]);
        }

        return new Collection($collection);
    }
}
