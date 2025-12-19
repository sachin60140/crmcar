<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtoModel extends Model
{
    protected $table = "dto_dispatch";

    protected $fillable = ['reg_number', 'rto_location', 'purchaser_name'];

    public function setRegNumberAttribute($value)
    {
        $this->attributes['reg_number'] = strtoupper($value);
    }

    public function setRtoLocationAttribute($value)
    {
        $this->attributes['rto_location'] = strtoupper($value);
    }

    public function setPurchaserNameAttribute($value)
    {
        // strtolower ensures that "JOHN DOE" becomes "John Doe" instead of staying "JOHN DOE"
        $this->attributes['purchaser_name'] = ucwords(strtolower($value));
    }
    
    
}
