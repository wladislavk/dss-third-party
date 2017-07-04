<?php

namespace Tests\Dummies\Eloquent;

use DentalSleepSolutions\Eloquent\AbstractModel;

/**
 * @SWG\Definition(
 * )
 *
 * @property int $id
 * @property \Carbon\Carbon|null $addDate
 * @property string|null $ipAddress
 * @property float $sum
 * @property-read \DentalSleepSolutions\Eloquent\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\UserCompany[] $users
 */
class FirstDummy extends AbstractModel
{

}
