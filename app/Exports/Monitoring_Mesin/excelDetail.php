<?php

namespace App\Exports\Monitoring_Mesin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Monitoring_Mesin\Pengiriman_Header;
use DB;

class excelDetail implements FromView, WithEvents
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id     = $id;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $model) {
                $model->writer->getProperties()->setCreator('SIRUS');
            },
            AfterSheet::class    => function(AfterSheet $model) {
                $model->sheet->getColumnDimension('A')->setWidth(5);
                $model->sheet->getColumnDimension('B')->setWidth(11);
                $model->sheet->getColumnDimension('C')->setWidth(22);
                $model->sheet->getColumnDimension('D')->setWidth(20);
                $model->sheet->getColumnDimension('E')->setWidth(12);
                $model->sheet->getColumnDimension('F')->setWidth(25);
                $model->sheet->getStyle('A6:A500')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $model->sheet->getStyle('A6:G6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }

    public function view(): View
    {   
        $model = Pengiriman_Header::findOrFail($this->id);
        $detail = DB::table('hd_detail_kiriman as detail')
        ->leftJoin('hd_jenis_mesin as jenis', 'jenis.id', '=', 'detail.jenis_id')
        ->leftJoin('hd_tipe_mesin as tipe', 'tipe.id', '=', 'detail.tipe_id')
        ->leftJoin('ba_gudang_alamat as gd', 'gd.id', '=', 'detail.gudang_id')
        ->select([
            'detail.jenis_id','jenis.jenis','detail.tipe_id','tipe.tipe','detail.nomor','detail.kondisi','detail.gudang_id','gd.nama_gudang'
        ])
        ->where('detail.header_id', $this->id)->get();
        
        return view('monitoring_mesin.report.exceldetail', [ 
            'model' => $model,
            'detail' => $detail
        ]);
    }
}
