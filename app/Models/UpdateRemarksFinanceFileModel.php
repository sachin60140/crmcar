<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateRemarksFinanceFileModel extends Model
{
    public $table="finance_remarks";
    use HasFactory;
    
    static function getremarksdetails($id)
    {
            $return = UpdateRemarksFinanceFileModel::select('finance_remarks.*','finance_file.cutomer_name as cutomer_name')
                    ->join('finace_file','finace_file.id', 'finance_remarks.finace_file_id')
                    ->get();
        return $return; 
        
    }
}
