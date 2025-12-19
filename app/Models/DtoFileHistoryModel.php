<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtoFileHistoryModel extends Model
{
   use HasFactory;
   public $table="dto_file_histories";

   protected $fillable = [
        'dto_file_id',
        'status',
        'file_name', // Added this
        'remarks',
        'created_by'
    ];

}
