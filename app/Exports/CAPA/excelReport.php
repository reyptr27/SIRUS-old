<?php

namespace App\Exports\CAPA;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\CAPA\CAPA;

class excelReport implements FromView, WithEvents
{
    use Exportable;

    public function __construct(string $tgl_awal,string $tgl_akhir,string $lokasi_id, string $dept_id)
    {
        $this->tgl_awal     = $tgl_awal;
        $this->tgl_akhir    = $tgl_akhir;
        $this->lokasi_id    = $lokasi_id;
        $this->dept_id      = $dept_id;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $model) {
                $model->writer->getProperties()->setCreator('SIRUS');
            },
            AfterSheet::class    => function(AfterSheet $model) {
                $model->sheet->getColumnDimension('A')->setWidth(22);
                $model->sheet->getColumnDimension('B')->setWidth(17);
                $model->sheet->getColumnDimension('C')->setWidth(40);
                $model->sheet->getColumnDimension('D')->setWidth(24);
                $model->sheet->getColumnDimension('E')->setWidth(20);
                $model->sheet->getColumnDimension('F')->setWidth(40);
                $model->sheet->getColumnDimension('G')->setWidth(40);
                $model->sheet->getColumnDimension('H')->setWidth(40);
                $model->sheet->getColumnDimension('I')->setWidth(18);
                $model->sheet->getColumnDimension('J')->setWidth(40);
                
                $model->sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $model->sheet->getStyle('A2:A500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('B2:B500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('C2:C500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('C2:C500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
                $model->sheet->getStyle('D2:D500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('D2:D500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $model->sheet->getStyle('E2:E500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('F2:F500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('F2:F500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
                $model->sheet->getStyle('G2:G500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('G2:G500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
                $model->sheet->getStyle('H2:H500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('H2:H500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
                $model->sheet->getStyle('I2:I500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('J2:J500')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)->setWrapText(true);
                $model->sheet->getStyle('J2:J500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);
            },
        ];
    }

    public function view(): View
    {   
        //Ambil data yang sudah verif
        $model  = CAPA::whereBetween('created_at', [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:00"])->where('status',2);
               
        if($this->lokasi_id != null){
            $model = $model->where('lokasi_id', $this->lokasi_id);
        }

        if($this->dept_id != null){
            $model = $model->where('kepada_id', $this->dept_id);
        }

        $model = $model->get();
        
        return view('capa.report.excel', [ 
            'model' => $model
        ]);
    }
}
