<?php
/**
 * Created by PhpStorm.
 * User: saqib
 * Date: 1/25/15
 * Time: 8:24 PM
 */

namespace Ds3\Eloquent;


use Illuminate\Database\Eloquent\Model;

class AdminCompany extends Model {

    protected $table = 'admin_company';
    protected $primaryKey = 'id';

    protected $fillable = ['ip_address','companyid','adminid'];

    public function company()
    {
        $this->hasOne('Ds3\Eloquent\Company');
    }
}