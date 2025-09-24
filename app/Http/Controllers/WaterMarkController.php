<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaterMarkController extends Controller
{
    public function watermark()
    {
        return view('other.watermark');
    }

    public function qrcode()
    {
        return view('other.qr-code');
    }
}
