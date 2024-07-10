<?php

namespace App\Repositories;

use App\Models\PartTime;
use Maatwebsite\Excel\Facades\Excel;

class ExportParttimeWorker
{
    public function export()
    {
        try {
                $parttimeWorkers = PartTime::get();
                
                if ($parttimeWorkers->isEmpty()) {
                    return response()->json(['error' => 'No parttime workers data found.'], 404);
                }
                
                $excelData = []; 
                
                foreach ($parttimeWorkers as $pt) {  
                    
                    $excelData[] = [
                        "Name" => $pt->name,
                        "NRC" => $pt->nrc,
                        "DOB" => $pt->dob,
                        "Photo" => $pt->photo,
                        "Phone" => $pt->phone,
                        "Address" => $pt->address
                    ];
                }

                return Excel::create('parttime_workers', function ($excel) use ($excelData) {
                    $excel->sheet('Sheet 1', function ($sheet) use ($excelData) {
                        $sheet->fromArray($excelData);
                    });
                })->download('xlsx');             
                        
            } catch (\Exception $e) {
                \Log::error('Error exporting data:', [$e->getMessage()]);
                return response()->json(['error' => 'Error exporting data.'], 500);
        }
    } 
}
