<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\User as BaseUser;
use DentalSleepSolutions\Eloquent\Models\Dental\User as DentalUser;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class CurrentUserInfoRetriever
{
    /** @var UserNumberRetriever */
    private $userNumberRetriever;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserNumberRetriever $userNumberRetriever, UserRepository $userRepository)
    {
        $this->userNumberRetriever = $userNumberRetriever;
        $this->userRepository = $userRepository;
    }

    /**
     * @param BaseUser $user
     * @return array
     * @throws RepositoryException
     */
    public function getCurrentUserInfo(BaseUser $user): array
    {
        $userData = $this->userNumberRetriever->addUserNumbers($user);
        /** @var DentalUser|null $dentalUser */
        $dentalUser = $this->userRepository->findOrNull($user->userid);
        $useCourse = 0;
        if ($dentalUser) {
            $useCourse = $dentalUser->use_course;
        }
        $userData['use_course'] = $useCourse;
        /** @var DentalUser|null $doctor */
        $doctor = $this->userRepository->findOrNull($user->getDocIdOrZero());
        $userData['doc_info'] = [];
        if ($doctor) {
            $userData['doc_info'] = $doctor->toArray();
        }
        return $userData;
    }
}
