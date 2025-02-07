<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function pricing()
    {
        $promotions = Promotion::all();
        return view('pricing', compact('promotions'));
    }
}
