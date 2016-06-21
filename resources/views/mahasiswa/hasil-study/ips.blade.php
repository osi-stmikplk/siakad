{{--
Load berdasarkan data yang dimasukkan adalah nilai IPS yang dibagi per semester. Untuk fleksibelitas maka tidak ada
mengikutsertakan layout utama, artinya agar yang memanggil ini melakukan setting nya, hal ini mengingat view ini akan
di load menggunakan format html dan juga bisa dijadikan pdf saat ingin di cetak
--}}

<style type="text/css">
th { text-align: center; }
</style>

<table class="table table-bordered table-condensed table-striped table-hover">
    <thead>
    <tr>
        <th>Semester</th>
        <th>SKS * Nilai Bobot</th>
        <th>Jumlah SKS</th>
        <th>IPS</th>
        <th>Cetak KHS</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr align="center">
            <td>{{ $d->semester }}</td>
            <td>{{ $d->jumBobotSKS }}</td>
            <td>{{ $d->jumSKS }}</td>
            <td>{{ number_format($d->jumBobotSKS / $d->jumSKS, 2, ",", ".") }}</td>
            <td>
				<button class="btn btn-xs btn-info" title="belum dibikin kata banghaji :)">
					<span class="glyphicon glyphicon-print"></span>
				</button>
			</td>
        </tr>
    @endforeach
    </tbody>
</table>