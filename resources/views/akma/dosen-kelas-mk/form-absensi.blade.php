@extends('layout.report')

@section('content')
<style type="text/css">
@media print {
    {{-- ubah ke landscape --}}
    @page { size: landscape;}
}
</style>
<h2 class="text-center">Daftar Hadir Mata Kuliah</h2>
<table class="table table-condensed">
    <thead>
    <tr>
        <th rowspan="2"><nobr>No.</nobr></th>
        <th rowspan="2">NIM</th>
        <th rowspan="2">Nama</th>
        <th colspan="16">Tanggal</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@endsection