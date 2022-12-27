<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreRegistration;
use Illuminate\Http\Request;

class PreRegistrationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'count' => PreRegistration::filter()->count(),
            'data'  => PreRegistration::orderBy('created_at', 'DESC')
                ->skip($request->skip ?? 0)
                ->take($request->limit ?? 50)
                ->filter()->get(),
        ]);
    }
}
