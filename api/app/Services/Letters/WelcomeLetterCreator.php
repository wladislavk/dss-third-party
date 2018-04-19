<?php

namespace DentalSleepSolutions\Services\Letters;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactTypeRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Http\Controllers\LettersController;

class WelcomeLetterCreator
{
    const SUCCESS_MESSAGE = 'This created an introduction letter. If you do not wish to send an introduction delete the letter from your Pending Letters queue.';

    const PHYSICIAN_ONE = 1;

    const DOC_ONE = 1;
    const DOC_TWO = 2;

    /** @var LetterComposer */
    private $letterComposer;

    /** @var UserRepository */
    private $userRepository;

    /** @var ContactTypeRepository */
    private $contactTypeRepository;

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(
        LetterComposer $letterComposer,
        UserRepository $userRepository,
        ContactTypeRepository $contactTypeRepository,
        LetterRepository $letterRepository
    ) {
        $this->letterComposer = $letterComposer;
        $this->userRepository = $userRepository;
        $this->contactTypeRepository = $contactTypeRepository;
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param int $docId
     * @param int $templateId
     * @param int $contactTypeId
     * @param int $userType
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createWelcomeLetter(int $docId, int $templateId, int $contactTypeId, int $userType): array
    {
        /** @var User|null $doctor */
        $doctor = $this->userRepository->find($docId);

        if (!$doctor || !$doctor->use_letters || !$doctor->intro_letters) {
            return [];
        }
        /** @var ContactType|null $contactType */
        $contactType = $this->contactTypeRepository->find($contactTypeId);

        if (!$contactType || $contactType->physician != self::PHYSICIAN_ONE) {
            return [];
        }

        if ($userType != LettersController::DSS_USER_TYPE_SOFTWARE) {
            $newFirstLetter = $this->letterComposer->composeWelcomeLetter(self::DOC_ONE, $templateId, $docId);
            $this->letterRepository->create($newFirstLetter);
        }

        $newSecondLetter = $this->letterComposer->composeWelcomeLetter(self::DOC_TWO, $templateId, $docId);
        $this->letterRepository->create($newSecondLetter);

        return ['message' => self::SUCCESS_MESSAGE];
    }
}
