<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class IzinApiController extends Controller
{
    public function index()
    {
        return response()->json([]);
    }

    public function store()
    {
        return response()->json([
            'success' => true
        ]);
    }
}