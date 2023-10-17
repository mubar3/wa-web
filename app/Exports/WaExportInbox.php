<?php

namespace App\Exports;

use App\Models\wa;
use App\Models\Inbox;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WaExportInbox implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnFormatting
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
        
        $query = Inbox::select(
                    '*',
                    'inboxes.nama as nama_pengirim',
                    'inboxes.telpon as telpon',
                    'inboxes.created_at as dikirim',
                    DB::raw("CASE WHEN inboxes.file = '' THEN NULL ELSE CONCAT('".url('/storage/inbox')."','/',inboxes.file) END AS file"),
                )
                ->leftjoin('contact', 'inboxes.telpon', '=', 'contact.telpon')
                ->leftjoin('api_was', 'api_was.url', '=', 'inboxes.api')
                ->where('api_was.tipe_id', 'like', '%' .$this->data->tipe . '%')
                ->where('inboxes.api', 'like', '%' .$this->data->api . '%')
                ->where('inboxes.jenis', 'like', '%' .$this->data->jenis . '%');
        if(!empty($this->data->tanggal_awal)){
                $query->where('inboxes.created_at','>=', $this->data->tanggal_awal ); }
        if(!empty($this->data->tanggal_akhir)){
                $query->where('inboxes.created_at','<=', $tanggal_akhir ); }
                
        $result= $query->orderBy('inboxes.created_at','desc')->get();

        $result= $query->get();

        foreach ($result as $key) {
            if(!(new Controller)->isNullOrEmpty($key->koordinat)){
                $koordinat=json_decode($key->koordinat,true);
                $key->koordinat='https://maps.google.com/?q='.$koordinat['lat'].','.$koordinat['long'];
            }
        }

        return $result;
        // return wa::all();
    }

     public function map($datas): array
    {
        return [
            // $invoice->invoice_number,
            // Date::dateTimeToExcel($invoice->created_at),
            $datas->api,
            $datas->telpon,
            $datas->nama,
            $datas->nama_pengirim,
            $datas->pesan,
            $datas->file,
            $datas->koordinat,
            $datas->jenis,
            $datas->dikirim,
        ];
    }

     public function headings(): array
    {
        return [
            'Api',
            'Pengirim',
            'Nama Kontak',
            'Nama WA',
            'Pesan',
            'File',
            'Koordinat',
            'Jenis',
            'Waktu',
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
