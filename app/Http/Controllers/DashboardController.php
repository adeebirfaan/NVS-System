<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function publicDashboard()
    {
        return view('dashboard.public');
    }

    public function mcmcDashboard()
    {
        return view('dashboard.mcmc');
    }

    public function agencyDashboard()
    {
        return view('dashboard.agency');
    }
}
