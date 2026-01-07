<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatementModel extends Model
{
    public $table="customer_ledger";
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_type',
        'amount',
        'particular',
        'created_by',
        // Add any other columns you are saving here
    ];
     public static function getRecord($customerId)
    {
        // Fetch oldest → newest (required for correct balance)
        $records = self::select(
                        'customer_ledger.*',
                        'ledger.name as name'
                    )
                    ->join('ledger', 'ledger.id', '=', 'customer_ledger.customer_id')
                    ->where('customer_ledger.customer_id', $customerId)
                    ->orderBy('customer_ledger.id', 'asc')
                    ->get();

        // Calculate running balance
        $balance = 0;
        foreach ($records as $row) {
            $balance += $row->amount;
            $row->running_balance = $balance;
        }

        // Reverse collection for latest-first display
        return $records->reverse()->values();
    }

    // static function getRecord($id)
    // {
    //     $return = CustomerStatementModel::select('customer_ledger.*', 'ledger.name as name')
    //                 ->join('ledger','ledger.id', 'customer_ledger.customer_id')
    //                 ->where('customer_id', $id)
    //                 ->orderBy('id', 'asc')
    //                 ->get();
    //                 return $return;
    // }
}
