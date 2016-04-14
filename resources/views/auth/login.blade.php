@extends('layout.no-wrapper')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form id="formLogin" class="form-horizontal" role="form"
                          method="POST" data-ic-post-to="{{ url('/login') }}">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Alamat Email / Username</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" placeholder="Ketikkan email / username anda">
                                <div id="error-email" class="help-block error"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                <div id="error-password" class="help-block error"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login @include('_ic-indicator')
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
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
