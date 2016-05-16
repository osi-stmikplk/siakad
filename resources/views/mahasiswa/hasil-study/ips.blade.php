{{--
Load berdasarkan data yang dimasukkan adalah nilai IPS yang dibagi per semester. Untuk fleksibelitas maka tidak ada
mengikutsertakan layout utama, artinya agar yang memanggil ini melakukan setting nya, hal ini mengingat view ini akan
di load menggunakan format html dan juga bisa dijadikan pdf saat ingin di cetak
--}}
<table class="table">
    <thead>
    <tr>
        <th>Semester</th>
        <th>SKS * Nilai Bobot</th>
        <th>Jumlah SKS</th>
        <th>IPS</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>
                {{ $d->semester }}
            </td>
            <td>
                {{ $d->jumBobotSKS }}
            </td>
            <td>
                {{ $d->jumSKS }}
            </td>
            <td>
                {{ number_format($d->jumBobotSKS / $d->jumSKS, 2, ",", ".") }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>