<?php

namespace App\Exports\Monitoring_Mesin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class excelReport implements FromView, WithEvents
{
    use Exportable;

    public function __construct(string $kategori,string $customer_id,string $tgl_awal,string $tgl_akhir)
    {
        $this->kategori     = $kategori;
        $this->customer_id  = $customer_id;
        $this->tgl_awal     = $tgl_awal;
        $this->tgl_akhir    = $tgl_akhir;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $model) {
                $model->writer->getProperties()->setCreator('SIRUS');
            },
            AfterSheet::class    => function(AfterSheet $model) {
                $model->sheet->getColumnDimension('A')->setWidth(5);
                $model->sheet->getColumnDimension('B')->setWidth(15);
                $model->sheet->getColumnDimension('C')->setWidth(22);
                $model->sheet->getColumnDimension('D')->setWidth(15);
                $model->sheet->getColumnDimension('E')->setWidth(40);
                $model->sheet->getColumnDimension('F')->setWidth(15);
                $model->sheet->getColumnDimension('G')->setWidth(18);
                $model->sheet->getColumnDimension('H')->setWidth(15);
                $model->sheet->getColumnDimension('I')->setWidth(18);
                $model->sheet->getColumnDimension('J')->setWidth(15);
                $model->sheet->getColumnDimension('K')->setWidth(25);
                $model->sheet->getStyle('A1:A500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $model->sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function view(): View
    {   

        $model = DB::table('hd_pengiriman_header as header')
                        ->leftJoin('tam_ba_rs as customer', 'customer.id', '=', 'header.customer_id')
                        ->leftJoin('users as creator', 'creator.id', '=', 'header.created_by')
                        ->leftJoin('users as updater', 'updater.id', '=', 'header.updated_by')
                        ->select([
                        'header.*','customer.id as customer_id','customer.nama_rs as customer','creator.name as creator','updater.name as updater'        
                        ])
        ->where('header.delete_status', 1);
            
        if($this->kategori != null){
            $model = $model->where('header.kategori', $this->kategori);
        }

        if($this->customer_id != null){
            $model = $model->where('customer_id', $this->customer_id);
        }
        $model = $model->whereBetween('header.created_at', [$this->tgl_awal." 00:00:00", $this->tgl_akhir." 23:59:00"])->get();
        
        return view('monitoring_mesin.report.excel', [ 
            'model' => $model
        ]);
    }
}
