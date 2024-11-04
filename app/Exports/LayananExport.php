<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\Setting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LayananExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
        // $this->setting = $setting;
    }

    public function view(): View
    {

        return view('ExcelLayanan', [
            'transaction' => $this->data,
            'setting' => Setting::first(),
        ]);
    }
}
