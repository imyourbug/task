<?php

namespace App\Http\Controllers\Admin\Volunteers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VolunteerHour;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class VolunteerController extends Controller
{
    public function index()
    {
        return view('admin.volunteer.index', [
            'title' => 'Volunteer Hours',
            'users' => User::all()
        ]);
    }

    public function getData()
    {
        $volunteer_hours = VolunteerHour::all();

        return Datatables::of($volunteer_hours)
            ->make(true);
    }

    public function getDataById($id)
    {
        $volunteer_hours = VolunteerHour::where('user_id', $id)->get();

        return Datatables::of($volunteer_hours)
            ->make(true);
    }
}
