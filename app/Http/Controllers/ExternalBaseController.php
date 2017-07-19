<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as IlluminateBaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\User as UserView;

abstract class ExternalBaseController extends IlluminateBaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $currentUser;
    protected $externalCompanyKey;
    protected $externalUserKey;
    protected $externalCompaniesRepository;
    protected $externalUsersRepository;

    public function __construct(
        ExternalCompany $externalCompanies,
        ExternalUser $externalUsers,
        Request $request,
        UserView $userView,
        User $userModel
    )
    {
        $this->externalCompaniesRepository = $externalCompanies;
        $this->externalUsersRepository = $externalUsers;
        $this->currentUser = $this->getUserInfo($request, $userView, $userModel);
    }

    private function getUserInfo($request, $userView, $userModel)
    {
        $this->externalCompanyKey = $request->input('api_key_company');
        $this->externalUserKey = $request->input('api_key_user');

        $externalUser = $this->externalUsersRepository->where('api_key', $this->externalUserKey)->first();
        $user = $userView->find('u_' . $externalUser->user_id)->first();

        $user->id = $externalUser->user_id;
        $user->docid = $userModel->getDocId($user->id)->docid ?: $user->userid;
        $user->user_type = $userModel->getUserType($user->docid)->user_type ?: 0;

        return $user;
    }
}
