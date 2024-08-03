<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatementModel extends Model
{
    public $table="customer_ledger";
    use HasFactory;

    static function getRecord($id)
    {
        $return = CustomerStatementModel::select('customer_ledger.*', 'ledger.name as name')
                    ->join('ledger','ledger.id', 'customer_ledger.customer_id')
                    ->where('customer_id', $id)
                    ->orderBy('id', 'asc')
                    ->get();
                    return $return;
    }
}
