<?php

namespace Tests\Dummies\Eloquent;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="FirstDummy",
 *     type="object",
 *     required={"id", "sum"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="addDate", type="string", format="dateTime"),
 *     @SWG\Property(property="ipAddress", type="string"),
 *     @SWG\Property(property="sum", type="float"),
 *     @SWG\Property(property="field1", type="string"),
 *     @SWG\Property(property="field2", type="string"),
 *     @SWG\Property(property="field3", type="string"),
 *     @SWG\Property(property="field4", type="string"),
 *     @SWG\Property(property="field5", type="string"),
 *     @SWG\Property(property="field6", type="string"),
 *     @SWG\Property(property="field7", type="string"),
 *     @SWG\Property(property="field8", type="string"),
 *     @SWG\Property(property="field9", type="string"),
 *     @SWG\Property(property="field10", type="string"),
 *     @SWG\Property(property="field11", type="string"),
 *     @SWG\Property(property="field12", type="string"),
 *     @SWG\Property(property="field13", type="string"),
 *     @SWG\Property(property="field14", type="string"),
 *     @SWG\Property(property="field15", type="string"),
 *     @SWG\Property(property="field16", type="string"),
 *     @SWG\Property(property="field17", type="string"),
 *     @SWG\Property(property="field18", type="string"),
 *     @SWG\Property(property="field19", type="string"),
 *     @SWG\Property(property="field20", type="string"),
 *     @SWG\Property(property="field21", type="string"),
 *     @SWG\Property(property="field22", type="string"),
 *     @SWG\Property(property="admin", ref="#/definitions/Admin"),
 *     @SWG\Property(property="users", type="array", @SWG\Items(ref="#/definitions/UserCompany"))
 * )
 *
 * @property int $id
 * @property \Carbon\Carbon|null $addDate
 * @property string|null $ipAddress
 * @property float $sum
 * @property string|null $field1
 * @property string|null $field2
 * @property string|null $field3
 * @property string|null $field4
 * @property string|null $field5
 * @property string|null $field6
 * @property string|null $field7
 * @property string|null $field8
 * @property string|null $field9
 * @property string|null $field10
 * @property string|null $field11
 * @property string|null $field12
 * @property string|null $field13
 * @property string|null $field14
 * @property string|null $field15
 * @property string|null $field16
 * @property string|null $field17
 * @property string|null $field18
 * @property string|null $field19
 * @property string|null $field20
 * @property string|null $field21
 * @property string|null $field22
 * @property-read \DentalSleepSolutions\Eloquent\Models\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Models\Dental\UserCompany[] $users
 */
class FirstDummy extends AbstractModel
{

}
