<?php

namespace App\Exports;

use App\Models\wa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class WaExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnFormatting
{

    function __construct($data) {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         if(!empty($this->data->tanggal_akhir)){
        $tanggal_akhir=Carbon::createFromFormat('Y-m-d', $this->data->tanggal_akhir);
        $tanggal_akhir=$tanggal_akhir->addDays(1);
        $tanggal_akhir=$tanggal_akhir->toDateString();  }       
        
        $query = wa::select('*','was.telpon as telpon','was.created_at as dikirim')
                ->leftjoin('contact', 'was.telpon', '=', 'contact.telpon')
                ->where('was.api', 'like', '%' .$this->data->api . '%');
        if(!empty($this->data->tanggal_awal)){
                $query->where('was.created_at','>=', $this->data->tanggal_awal ); }
        if(!empty($this->data->tanggal_akhir)){
                $query->where('was.created_at','<=', $tanggal_akhir ); }

        $result= $query->get();

        return $result;
        // return wa::all();
    }

     public function map($datas): array
    {
        $status_kirim='';
        if(!empty($datas->status_kirim)){
            $status_kirim='Terkirim';
        }else{
            $status_kirim='Gagal';
        }
        return [
            // $invoice->invoice_number,
            // Date::dateTimeToExcel($invoice->created_at),
            $datas->api,
            $datas->telpon,
            $datas->nama,
            $datas->pesan,
            $datas->dikirim,
            $status_kirim,
        ];
    }

     public function headings(): array
    {
        return [
            'Api',
            'Penerima',
            'Nama Kontak',
            'Pesan',
            'Waktu',
            'Status Kirim',
            // 'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

      public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            // 'B' => NumberFormat::FORMAT_NUMBER,
            // 'C' => NumberFormat::FORMAT_TEXT,
            // 'D' => NumberFormat::FORMAT_TEXT,
            // 'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
