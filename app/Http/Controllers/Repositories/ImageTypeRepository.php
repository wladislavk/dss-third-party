<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\ImageTypeInterface;
use Ds3\Eloquent\Imagetype;

class ImageTypeRepository implements ImageTypeInterface
{
    public function getActiveImageTypes()
    {
        $imagetypes = Imagetype::active()
            ->orderBy('sortby')
            ->get();

        return $imagetypes;
    }
}
