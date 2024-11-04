<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\Setting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengunjungExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {

        return view('ExcelPengunjung', [
            'transaction' => $this->data,
            'setting' => Setting::first(),
        ]);
    }
}
