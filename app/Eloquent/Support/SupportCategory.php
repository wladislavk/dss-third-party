<?php
namespace Ds3\Eloquent\Support;

use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    protected $table = 'dental_support_categories';
    protected $fillable = ['title', 'status'];
    protected $primaryKey = 'id';

    public static function get()
    {
        $supportCategory = SupportCategory::where('status', '=', 0)
            ->orderBy('title')
            ->get();

        return $supportCategory;
    }
}
