{{--
Load tampilan pertama kali / Dashboard
--}}
@extends($layout)

@section('content-header')
    <h1>STMIK Siakad<small>kepingin online</small></h1>
@endsection

@section('content')
<section id="dashboard">
    <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">Perhatian</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="callout callout-danger">
                <p>Masih Prototype Coy!</p>
            </div>
        </div><!-- /.box-body -->
    </div>
</section>
@endsection