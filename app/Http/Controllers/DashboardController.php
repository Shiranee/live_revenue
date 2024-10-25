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
        return view('dashboard.blade.php');  // Assuming you have a Blade template
    }
}
