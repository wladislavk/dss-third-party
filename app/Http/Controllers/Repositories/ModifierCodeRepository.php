<?php
namespace Ds3\Repositories;

use Ds3\Contracts\ModifierCodeInterface;
use Ds3\Eloquent\ModifierCode;

class ModifierCodeRepository implements ModifierCodeInterface
{
    public function getModifierCode($order)
    {
        $modifierCodes = ModifierCode::orderBy($order)->get();

        return $modifierCodes;
    }
}
