<?php

namespace DentalSleepSolutions\Structs;

class JwtPayload
{
    /** @var string */
    public $iss = 'DentalSleepSolutions';

    /** @var string */
    public $sub = 'Auth';

    /** @var string */
    public $aud = 'API';

    /** @var string */
    public $jti = 'DentalSleepSolutions-';

    /** @var string */
    public $iat = '';

    /** @var string */
    public $exp = '';

    /** @var string */
    public $nbf = '';

    public function toArray()
    {
        return [
            'iss' => $this->iss,
            'sub' => $this->sub,
            'aud' => $this->aud,
            'jti' => $this->jti,
            'iat' => $this->iat,
            'exp' => $this->exp,
            'nbf' => $this->nbf,
        ];
    }
}
