<?php
namespace App\Http\Controllers\Apiv2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HSEChecklistController extends Controller
{
    public function index()
    {
        return view('hrms.hse_checklist.hse_checklist');
    }
    
    public function indexOpt()
    {
        return view('hrms.hse_checklist.hse_opt_checklist');
    }
    
    public function indexRat()
    {
        return view('hrms.hse_checklist.hse_rat_checklist');
    }
    
    public function createOpt()
    {
        return view('hrms.hse_checklist.hse_opt_create');
    }
    
    public function createRat()
    {
        return view('hrms.hse_checklist.hse_rat_create');
    }
}
