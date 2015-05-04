<?php
namespace Ds3\Eloquent\Memo;

use Illuminate\Database\Eloquent\Model;

class MemoAdmin extends Model
{
    protected $table = 'memo_admin';
    protected $primaryKey = 'memo_id';

    public function scopeActual($query)
    {
        return $query->whereRaw('off_date <= CURDATE()');
    }
}
