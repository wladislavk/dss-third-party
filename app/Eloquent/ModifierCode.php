<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ModifierCode extends Model
{
    protected $table = 'dental_modifier_code';
    protected $fillable = ['modifier_code', 'description', 'sortby', 'status'];
    protected $primaryKey = 'modifier_codeid';

    public static function get($where = null)
    {
        $modifierCode = new ModifierCode();

        if (!empty($where)) {
            foreach ($where as $attribute => $value) {
                $modifierCode = $modifierCode->where($attribute, '=', $value);
            }
        }

        $modifierCode = $modifierCode->orderBy('sortby');                                                             

        return $modifierCode->get();
    }
}
