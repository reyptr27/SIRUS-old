<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Writer;
// use Maatwebsite\Excel\Concerns\FromCollection;

use DB;

class excelExport implements FromView
{
    use Exportable;

    public function __construct(string $startDate, string $endDate){
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('assets/images/logo-baru.jpg'));
                $drawing->setCoordinates('A1');

                $drawing->setWorksheet($event->sheet->getDelegate());
            },
        ];
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         BeforeExport::class  => function(BeforeExport $event) {
    //             $event->writer->setCreator('IT');
    //         },
    //         AfterSheet::class    => function(AfterSheet $event) {
    //             $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //             $event->sheet->columnWidth('A',15);
    //             $event->sheet->columnWidth('B',18);
    //             $event->sheet->columnWidth('C',40);
    //             $event->sheet->columnWidth('D',20);
    //             $event->sheet->columnWidth('E',15);
    //             $event->sheet->columnWidth('F',40);
    //             $event->sheet->columnWidth('G',50);
    //             $event->sheet->columnWidth('H',40);
    //             $event->sheet->columnWidth('I',15);
    //             $event->sheet->columnWidth('J',40);
    //             $event->sheet->wrapText('A1:J1000');
    //             $event->sheet->setAutoFilter('A1:J1');
    //             $event->sheet->horizontalAlign('A1:J1', \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //             $event->sheet->verticalAlign('A2:J1000' , \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
    //             $event->sheet->verticalAlign('A1:J1' , \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //         },
    //     ];
    // }

    public function view(): View
    {   
        
        return view('permintaan.exportperbaikan.excel', [
            'perbaikan' => DB::table('perbaikan')
                     ->join('users as pemohon', 'perbaikan.pemohon_id', '=', 'pemohon.id')
                    // ->join('pegawai as kepada', 'capa.kepada_id', '=', 'kepada.id')
                    // ->join('pegawai as pic', 'capa.pic_id', '=', 'pic.id')
                    // ->join('lokasi', 'capa.lokasi_id', '=', 'lokasi.id')
                    ->select(['perbaikan.id', 'perbaikan.created_at', 
                    'perbaikan.no_document', 'perbaikan.deskripsi',
                    'pemohon.name as pemohon'
                        
                    ])
                    ->whereBetween('perbaikan.created_at', [$this->startDate." 00:00:00", $this->endDate." 23:00:00"])
                    ->orderBy('created_at', 'ASC')->get()
        ]);
    }
}
