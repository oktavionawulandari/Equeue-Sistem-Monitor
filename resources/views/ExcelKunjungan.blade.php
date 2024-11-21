<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <table class='table table-bordered' style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th style="font-weight: bold; border: 1px solid black;"><img src="{{ 'storage/logo/' . $setting->logo }}" alt="{{ $setting->instansi }}" width="70px" height="70px"></th>
                <th colspan="7" style="font-weight: bold; border: 1px solid black; font-size:13px;">
                    <h2 >{{ $setting->instansi ?? '-' }}</h2>
                    <p>{{ $setting->address ?? '-' }}</p>
                    <p>{{ $setting->phone ?? '-' }} / {{ $setting->email }}</p>
                </th>
            </tr>
            <tr>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">No</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Nomor Antrian</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Kategori</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Nama Loket</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Status</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Operator</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Tanggal</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">Instansi</th>
                <th style="font-weight: bold; border: 1px solid black; font-size:12px;">HP</th>

            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($transaction as $t)
                <tr>
                    <td style="border: 1px solid black; font-size:12px;">{{ $no++ }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->queue->no }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->category->name }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->counter->name ?? '-' }}</td>
                    <td style="border: 1px solid black; font-size:12px;">
                    @if ($t->queue->status == 1)
                        Menunggu
                    @elseif ($t->queue->status == 2 || $t->queue->status == 3)
                        Dipanggil
                    @elseif ($t->queue->status == 4)
                        Berhasil
                    @elseif ($t->queue->status == 5)
                        Dibatalkan
                    @else
                        -
                    @endif
                    </td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->user->name ?? '-' }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->date }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->instansi->name ?? '-' }}</td>
                    <td style="border: 1px solid black; font-size:12px;">{{ $t->queue->phone ?? '-' }}</td>


                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
