<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Permintaan\Perbaikan;
// use App\Exports\PerbaikanExport;
use PDF;
use App\Exports\excelExport;

class ExportController extends Controller
{
    public function exportperbaikan(Request $request)
	{
        // return Excel::download(new PerbaikanExport, 'rekap_perbaikan.xlsx');
        $this->validate($request, [
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        switch ($request->input('action')) {
            case 'excel':
                return (new excelExport($request->startDate, $request->endDate))
                ->download('rekap_perbaikan.xls');   
                // return response()->json(['start' => $request->startDate, 'end' => $request->endDate]);         
            break;
            
            case 'pdf':
                $perbaikan = Perbaikan::whereBetween('created_at', [$request->startDate." 00:00:00", $request->endDate." 23:00:00"])->orderBy('created_at', 'ASC')->get();

                $pdf = PDF::loadView('permintaan.exportperbaikan.pdf', compact('perbaikan'))->setPaper('a4', 'landscape');
                return $pdf->stream('rekap_perbaikan.pdf');
                
            break;
        }
	}
}
