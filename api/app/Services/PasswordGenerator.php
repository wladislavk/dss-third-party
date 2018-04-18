<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Contracts\PasswordInterface;
use Illuminate\Contracts\Hashing\Hasher as BcryptHasher;
use DentalSleepSolutions\Wrappers\HashWrapper as LegacyHasher;

class PasswordGenerator
{
    /** @var BcryptHasher */
    private $bcryptHasher;

    /** @var LegacyHasher */
    private $legacyHasher;

    /**
     * @param BcryptHasher $bcryptHasher
     * @param LegacyHasher $legacyHasher
     */
    public function __construct(
        BcryptHasher $bcryptHasher,
        LegacyHasher $legacyHasher
    )
    {
        /**
         * @todo Ensure Hasher service loads Bcrypt hasher
         */
        $this->bcryptHasher = $bcryptHasher;
        $this->legacyHasher = $legacyHasher;
    }

    /**
     * @param string $password
     * @param PasswordInterface $passwordStruct
     */
    public function generatePassword($password, PasswordInterface $passwordStruct)
    {
        $hashedPassword = $this->bcryptHasher->make($password);
        $salt = $this->extractSaltFromBcryptPassword($hashedPassword);
        $passwordStruct->setSalt($salt);
        $passwordStruct->setPassword($hashedPassword);
    }

    /**
     * @param string $password
     * @param PasswordInterface $passwordStruct
     */
    public function generateLegacyPassword($password, PasswordInterface $passwordStruct)
    {
        $salt = $this->createSalt();
        $hashedPassword = $this->hash($password, $salt);
        $passwordStruct->setSalt($salt);
        $passwordStruct->setPassword($hashedPassword);
    }

    /**
     * @todo IMPORTANT! these functions might not be cryptographically secure!
     * @todo it is highly advisable to switch to native Laravel security methods
     * @return string
     */
    public function createSalt()
    {
        $weakSalt = $this->createLegacySalt();
        $bcryptPassword = $this->bcryptHasher->make($weakSalt);
        $strongSalt = $this->extractSaltFromBcryptPassword($bcryptPassword);

        return $strongSalt;
    }

    /**
     * @return string
     */
    public function createLegacySalt()
    {
        $weakSalt = rand();
        $weakSalt = uniqid($weakSalt, true);
        $weakSalt = $this->legacyHasher->sha1($weakSalt);
        $weakSalt = substr($weakSalt, 0, 12);

        return $weakSalt;
    }

    /**
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function hash($password, $salt)
    {
        return $this->legacyHasher->hash('sha256', $password . $salt);
    }

    /**
     * @param string $password
     * @param string $hashedPassword
     * @param string $salt
     * @return bool
     */
    public function verify($password, $hashedPassword, $salt)
    {
        if (substr($hashedPassword, 0, 1) === '$') {
            return $this->bcryptHasher->check($password, $hashedPassword);
        }

        return $this->legacyHasher->hashEquals($hashedPassword, $this->hash($password, $salt));
    }

    /**
     * @param string $bcryptPassword
     * @return string
     */
    private function extractSaltFromBcryptPassword($bcryptPassword)
    {
        $strongSalt = preg_replace('/^\$.+?\$.+?\$(.{22}).+$/', '$1', $bcryptPassword);
        return $strongSalt;
    }
}
