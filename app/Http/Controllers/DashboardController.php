<?php

namespace App\Http\Controllers;


use App\Models\Position;
use App\Models\Role;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            "title" => "Dashboard",
            "positionCount" => Position::count(),

            "employeeCount" => User::count(),
            // get all employee where position is internship
            "internshipOnly" => User::where('position_id', Position::INTERNSHIP_POSITION_ID)->count(),

            // get all employee where position is not internship and not manager
            "staffOnly" => User::where('position_id', '!=', Position::MANAGER_POSITION_ID)
                ->where('position_id', '!=', Position::INTERNSHIP_POSITION_ID)->count(),

            // staff presence where date is today
            "staffPresentCount" => Presence::where('presence_date', now()->toDateString())
                ->wherehas('user', function ($query) {
                    $query->where('position_id', '!=', Position::MANAGER_POSITION_ID)
                        ->where('position_id', '!=', Position::INTERNSHIP_POSITION_ID);
                })->count(),

            // internship presence where date is today
            "internshipPresentCount" => Presence::where('presence_date', now()->toDateString())
                ->whereHas('user', function ($query) {
                    $query->where('position_id', Position::INTERNSHIP_POSITION_ID);
                })->count(),
        ]);
    }
}
