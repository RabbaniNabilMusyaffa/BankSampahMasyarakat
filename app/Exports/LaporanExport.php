<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data_laporan;

    public function __construct($data_laporan)
    {
        $this->data_laporan = $data_laporan;
    }

    public function view(): View
    {
        return view('page_admin.laporan_export', [
            'data_laporan' => $this->data_laporan
        ]);
    }
}
