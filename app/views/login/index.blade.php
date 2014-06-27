@extends( 'layouts.default' )

@section('content')
    <section class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                {{ Form::open(['route' => 'login.index', 'role' => 'form']) }}
                    <fieldset>
                        <h2><i class="fa fa-user"></i> Sign In <small style="letter-spacing:-1px">to continue</small></h2>
                        <p class="help-block">Use your workstation login credentials.</p>

                        @foreach( ['logout_successful'] as $flash )
                            @if( Session::has( $flash ) )
                                <hr/>
                                <div class="alert alert-success">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    {{ Session::get( $flash ) }}
                                </div>
                            @endif
                        @endforeach

                        @if( $errors->has('login_failed') )
                            <hr/>
                            <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                {{ $errors->first('login_failed') }}
                            </div>
                        @endif
                        <hr>
                        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                            @if( $errors->has('username') )
                                {{ Form::text('username', null, ['id' => 'username', 'class' => 'form-control input-lg alert-danger', 'placeholder' => 'Username']) }}
                                {{ $errors->first('username', '<span class="help-block">:message</span>') }}
                            @else
                                {{ Form::text('username', null, ['id' => 'username', 'class' => 'form-control input-lg', 'placeholder' => 'Username']) }}
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            @if( $errors->has('password') )
                                {{ Form::password('password', ['id' => 'password', 'class' => 'form-control input-lg alert-danger', 'placeholder' => 'Password']) }}
                                {{ $errors->first('password', '<span class="help-block">:message</span>') }}
                            @else
                                {{ Form::password('password', ['id' => 'password', 'class' => 'form-control input-lg', 'placeholder' => 'Password']) }}
                            @endif
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-5 col-sm-4 col-xs-12">
                                <button class="btn btn-lg btn-success btn-block" type="submit">
                                    <span class="glyphicon glyphicon-log-in"></span>
                                    Sign In
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </section>
@stop