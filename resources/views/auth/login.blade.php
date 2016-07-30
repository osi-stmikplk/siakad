@extends('layout.no-wrapper')

@section('content')
<style type="text/css">
.well { background: #ffffff; }
.dialog {
	width: 250px;
	margin: 7% auto 0;
	padding: 20px;
	text-align: center;
}
</style>

<div class="container">
    <div class="row">
        <div class="">
            <div class="well dialog">
				<img src="/plugins/logo_stmikplk.jpg" width="80px">
                <h4 class="text-primary"><strong>STMIK Palangka Raya</strong></h4>
                <h6 class="text-danger"><strong>{{ config('siakad.slogan') }}</strong></h6>
				<hr>
				<!--h3 class="text-success">Login System</h3-->
                <div>
                    <form id="formLogin" class="form-horizontal" role="form"
                          method="POST" data-ic-post-to="{{ url('/login') }}">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input type="text" class="form-control" name="email" placeholder="ID Pengguna">
								</div>
								<div id="error-email" class="help-block error"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input type="password" class="form-control" name="password" placeholder="Sandi">
								</div>
                                <div id="error-password" class="help-block error"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Diingat?
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-6">
								<span class="pull-right">
									<a class="btn btn-link" href="{{ url('/password/reset') }}">Lupa sandi?</a>
								</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-btn fa-sign-in"></i> Masuk @include('_ic-indicator')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
				<hr>
				&copy; IT STMIK Palangka Raya
            </div>
        </div>
    </div>
</div>
@endsection

@push('late-script')
<script type="text/javascript">

$('#formLogin')
    .on('error.ic',function(evt, elt, status, str, xhr){
        if(xhr.status==422) {
            TSSTMIK.resetFormErrorMsg('form#formLogin div.error');
            TSSTMIK.showFormErrorMsg(xhr.responseText);
        } else {

        }
    });
//    .on('success.ic',function(evt, elt, data, textStatus, xhr, requestId){
//            window.location.replace("/");
//    });
TSSTMIK.resetFormErrorMsg('form#formLogin div.error');
</script>
@endpush
