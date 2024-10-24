<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Other shared methods can go here
}

class DashboardController extends Controller
{
    public function showRevenueEcomm()
    {
        return view('dashboards.revenue_ecomm.index');  // Assuming you have a Blade template
    }
}
