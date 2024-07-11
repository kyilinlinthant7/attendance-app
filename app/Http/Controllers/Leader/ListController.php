<?php

namespace App\Http\Controllers\Leader;


use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;

class ListController extends Controller
{
    public function getShifts($siteId) 
    {
        $project = Project::findOrFail($siteId);
        $shifts = $project->shifts()->where('delete_status', 0)->get();
        
        return response()->json($shifts);
    }

    public function otherLink($userId)
    {
        $user = Employee::find($userId);

        return view('leader.other_link', compact('user', 'userId'));
    }
}
