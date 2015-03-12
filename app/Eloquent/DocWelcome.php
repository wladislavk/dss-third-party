<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class DocWelcome extends Model
{
    protected $table = 'dental_doc_welcome';
    protected $fillable = ['title', 'video_file', 'status'];
    protected $primaryKey = 'doc_welcomeid';

    public static function get($docId)
    {
        $docWelcome = DocWelcome::where('status', '=', 1)
            ->where(DB::raw("(docid = '' or docid like '%~" . $docId . "~%')"))
            ->orderBy('sortby')
            ->get();

        return $docWelcome;
    }
}
