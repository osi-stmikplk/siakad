{{--
Layout ini digunakan untuk request terhadap page berbasiskan ajax, jadi tidak lagi diikutsertakan untuk mengambil
header dari halaman seperti halnya layout.main. Apabila ada dependency maka harap di deklarasikan sendiri.
@Feb 2016 Yan F
--}}
{{-- Content Header (Page header) --}}
<section class="content-header">
    @yield('content-header')
</section>
{{-- Main content --}}
<section class="content">
    @yield('content')
</section>
{{-- /.content --}}
@stack('late-script')