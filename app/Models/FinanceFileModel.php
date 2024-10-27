<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceFileModel extends Model
{
    public $table="finace_file";
    use HasFactory;

    static function getrecord()
    {
        $return = FinanceFileModel::select('finace_file.*','financer_details.financer_name as financer_name','finance_file_status.file_status_type as finance_file_status')
                    ->join('financer_details','financer_details.id', 'finace_file.financer_details_id')
                    ->join('finance_file_status','finance_file_status.id','finace_file.file_status')
                    ->orderBy('finace_file.id','asc')
                    ->get();
        return $return; 

    }
    static function getrecorddetails($id)
    {
            $return = FinanceFileModel::select('finace_file.*','financer_details.financer_name as financer_name','finance_file_status.file_status_type as finance_file_status')
                    ->join('financer_details','financer_details.id', 'finace_file.financer_details_id')
                    ->join('finance_file_status','finance_file_status.id','finace_file.file_status')
                    ->orderBy('finace_file.id','asc')
                    ->where('finace_file.id','=', $id)
                    ->get();
        return $return; 
    }

    static function getdeliveredrecord()
    {
        $return = FinanceFileModel::select('finace_file.*','financer_details.financer_name as financer_name','finance_file_status.file_status_type as finance_file_status')
                    ->join('financer_details','financer_details.id', 'finace_file.financer_details_id')
                    ->join('finance_file_status','finance_file_status.id','finace_file.file_status')
                    ->where('finace_file.file_status','=','5')
                    ->orderBy('finace_file.id','asc')
                    ->get();
        return $return;
    }
}
