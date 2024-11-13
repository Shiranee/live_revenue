<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\dispatchesService;
use Carbon\Carbon;

class crmDispatchesController extends Controller
{
    public function crmDispatchesIndex() {
        return view('dashboards.crmDispatches');
    }
}