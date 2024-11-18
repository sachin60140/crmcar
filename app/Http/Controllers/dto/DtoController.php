<?php

namespace App\Http\Controllers\dto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DtoController extends Controller
{
    public function index()
    {
        return view("admin.dto.add-file");
    }
}
