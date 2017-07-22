<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\UserSignature;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSignatureRepository extends BaseRepository
{
    public function model()
    {
        return UserSignature::class;
    }

    /**
     * @param int $userId
     * @return UserSignature|null
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
