<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CptCode extends Model
{
    protected $table = 'dental_cpt_code';
    protected $fillable = ['cpt_code', 'description', 'sortby', 'status'];
    protected $primaryKey = 'cpt_codeid';

    public static function get()
    {
        $cptCode = CptCode::where('status', '=', 1)
            ->orderBy('sortby')
            ->get();

        return $cptCode;
    }
}
