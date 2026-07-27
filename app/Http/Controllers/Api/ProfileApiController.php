<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status'=>true,
            'user'=>Auth::user()
        ]);
    }
}