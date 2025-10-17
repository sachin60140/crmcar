<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JustDailModel extends Model
{
    public $table="just_dail_data";
    use HasFactory;

     

    protected $fillable = [
        'leadid','leadtype','prefix','name','mobile','phone','email','date','category','city','area','brancharea','dncmobile','dncphone','company','pincode','time','branchpin','parentid'
    ] ;
}
