{{--
Cetak KHS
--}}
<h1>Kartu Rencana Study</h1>
<table>
    <tr>
        <td>NIM</td>
        <td>{{ $mhs->nomor_induk }}</td>
        <td>Angkatan</td>
        <td>{{ $mhs->tahun_masuk }}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>{{ $mhs->nama }}</td>
        <td>Semester</td>
        <td>{{ $mhs->dapatkanSemester($ta) }}</td>
    </tr>
    <tr>
        <td>Program Studi</td>
        <td>{{ $mhs->jurusan->nama }}</td>
        <td>Tahun Ajaran</td>
        <td>{{ $ta }}</td>
    </tr>
</table>
<?php $i = $jumlahSKS = 0; ?>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Kelas</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rincianStudi as $ris)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $ris->kode_mk }}</td>
            <td>{{ $ris->nama_mk }}</td>
            <td>{{ $ris->sks }}</td>
            <td>{{ $ris->kelas }}</td>
            <td>&nbsp;</td>
        </tr>
        <?php $jumlahSKS += $ris->sks ?>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Jumlah SKS</td>
            <td>{{ number_format($jumlahSKS) }}</td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<p>
    Palangka Raya,<br>
    Pembimbing Akademik<br>
<br>
<br>
    ______________________________
</p>
<p>Tanggal Cetak {{ date('d-m-Y H:i') }}</p>