<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\UserSignature;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class UserSignatureRepository extends AbstractRepository
{
    public function model()
    {
        return UserSignature::class;
    }

    /**
     * @param int $userId
     * @return Model|UserSignature|null
     */
    public function formUser($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    /**
     * @param int $userId
     * @param string $signatureJson
     * @param string $ipAddress
     * @return int
     */
    public function addUpdate($userId, $signatureJson, $ipAddress)
    {
        if ($updated = $this->model->where('user_id', $userId)->first()) {
            $this->model->where('user_id', $userId)
                ->update([
                    'signature_json' => $signatureJson,
                    'ip_address' => $ipAddress,
                ]);

            return $updated->id;
        }

        $new = new UserSignature();
        $new->user_id = $userId;
        $new->signature_json = $signatureJson;
        $new->adddate = Carbon::now();
        $new->ip_address = $ipAddress;
        $new->save();

        return $new->id;
    }
}
