<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class SystemMonitor extends Controller
{
    public function horizon(): Response
    {
        return Inertia::render('SystemMonitor/Horizon');
    }

    public function telescope(): Response
    {
        return Inertia::render('SystemMonitor/Telescope');
    }
}
