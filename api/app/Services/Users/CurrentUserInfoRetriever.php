<?php

namespace DentalSleepSolutions\Services\Users;

use DentalSleepSolutions\Eloquent\Models\Dental\User;
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
     * @param User $user
     * @return array
     * @throws RepositoryException
     * @throws \DentalSleepSolutions\Exceptions\GeneralException
     */
    public function getCurrentUserInfo(User $user): array
    {
        $userData = $this->userNumberRetriever->addUserNumbers($user);
        $userData['use_course'] = $user->use_course;
        $userData['doc_info'] = [];
        if (!$user->docid) {
            $userData['doc_info'] = $user->toArray();
            return $userData;
        }
        /** @var User|null $doctor */
        $doctor = $this->userRepository->findOrNull($user->docid);
        if ($doctor) {
            $userData['doc_info'] = $doctor->toArray();
        }
        return $userData;
    }
}
