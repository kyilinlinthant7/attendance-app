<?php

namespace App\Http\Controllers;

use App\Models\PartTime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ExportParttimeWorker;

class PartTimeController extends Controller
{
    protected $exportParttimeWorker;
    
    public function __construct(ExportParttimeWorker $exportParttimeWorker)
    {
        $this->exportParttimeWorker = $exportParttimeWorker;
    }
    
    public function add(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ]);

        $photoPath = "";
        $photo = $request->file('photo');
        
        if ($request->hasFile('photo')) {
            
            $imageName = Carbon::now()->format('YmdHis') . '.' . $photo->getClientOriginalExtension();
            
            if ($photo->move('public/parttime_workers/', $imageName)) {
                $photoPath = "public/parttime_workers/" . $imageName;
            } else {
                return response()->json(['error' => 'Failed to move the uploaded file'], 500);
            }
        }
        
        PartTime::create([
            'name' => $request->ptname,
            'nrc' => $request->ptnrc,
            'dob' => $request->ptdob,
            'phone' => $request->ptphone,
            'address' => $request->ptaddress,
            'photo' => $photoPath
        ]);
    
        \Session::flash('flash_message', 'Part-time worker successfully added!');

        return redirect()->back();
    }
    
    public function edit(Request $request, $id)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ]);
    
        $partTime = PartTime::findOrFail($id);
    
        $photoPath = $partTime->photo;
        
        if ($request->hasFile('photo')) {
            
            $photo = $request->file('photo');
            
            $imageName = Carbon::now()->format('YmdHis') . '.' . $photo->getClientOriginalExtension();
            
            if ($photo->move('public/parttime_workers/', $imageName)) {
                $photoPath = "public/parttime_workers/" . $imageName;
    
                $partTime->photo = $photoPath;
            } else {
                return response()->json(['error' => 'Failed to move the uploaded file'], 500);
            }
        }
        
        $partTime->update([
            'name' => $request->ptname,
            'nrc' => $request->ptnrc,
            'dob' => $request->ptdob,
            'phone' => $request->ptphone,
            'address' => $request->ptaddress,
            'photo' => $photoPath
        ]);
    
        \Session::flash('flash_message', 'Part-time worker successfully updated!');
    
        return redirect()->back();
    }

    public function list()
    {
        $datas = PartTime::where('delete_status', 0)->latest()->paginate(10);

        return view('hrms.parttimeworkers.list', compact('datas'));
    }

    public function delete($id) 
    {
        $pt = PartTime::find($id);
        $pt->delete_status = 1;
        $pt->save();

        \Session::flash('flash_message', 'Partime worker deleted successfully.');
        return redirect()->back();
    }

    public function searchPartTime(Request $request)
    {
        $datas = PartTime::where('name', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('phone', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('address','LIKE', '%' . $request->keywords . '%')
            ->where('delete_status', 0)
            ->latest()
            ->paginate(10);

        return view('hrms.parttimeworkers.list', compact('datas'));
    }
    
    public function export(Request $request)
    {
        return $this->exportParttimeWorker->export();
    }
}
