<?php

namespace Yungts97\LaravelUserActivityLog\Controllers;

use App\Http\Controllers\Controller;
use Yungts97\LaravelUserActivityLog\Models\Log;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(Log::viewThisMonthActivity()->get());
    }

}