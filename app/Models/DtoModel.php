<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtoModel extends Model
{
    public $table="dto_dispatch";

    public function setReg_numberAttribute($value)
    {
        $this->attributes['reg_number'] = strtoupper($value);
    }
    public function setRto_locationAttribute($value)
    {
        $this->attributes['rto_location'] = strtoupper($value);
    }
    public function setPurchaser_nameAttribute($value)
    {
        $this->attributes['purchaser_name'] = ucwords($value);
    }
    
    
}
