<?php

namespace DentalSleepSolutions\Structs;

class JwtPayload
{
    /** @var string */
    public $issuer = 'DentalSleepSolutions';

    /** @var string */
    public $subject = 'Auth';

    /** @var string */
    public $audience = 'API';

    /** @var string */
    public $jwtUniqueId = 'DentalSleepSolutions-';

    /** @var string */
    public $issuedAt = '';

    /** @var string */
    public $expiresAt = '';

    /** @var string */
    public $notBefore = '';

    public function toArray()
    {
        return [
            'iss' => $this->issuer,
            'sub' => $this->subject,
            'aud' => $this->audience,
            'jti' => $this->jwtUniqueId,
            'iat' => $this->issuedAt,
            'exp' => $this->expiresAt,
            'nbf' => $this->notBefore,
        ];
    }
}
