@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li class="active"><i class="fa fa-pencil"></i> Create</li>
        </ol>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading"><i class="fa fa-pencil"></i> Create New Machine Record</div>
                  <div class="panel-body">
                    {{ Form::model( $machine , ['role' => 'form', 'route' => 'machines.store'] ) }}
                        <fieldset>
                            <div class="form-group {{ $errors->has('mac_address') ? 'has-error' : '' }}">
                                <p>What is the computer's mac address? <small>(Use getmac command)</small></p>
                                @if( $errors->has('mac_address') )
                                    {{ Form::text('mac_address', null, ['id' => 'mac_address', 'class' => 'form-control alert-danger']) }}
                                    {{ $errors->first('mac_address', '<span class="help-block">:message</span>') }}
                                @else
                                    {{ Form::text('mac_address', null, ['id' => 'mac_address', 'class' => 'form-control', 'placeholder' => 'Format: xx-xx-xx-xx-xx-xx']) }}
                                @endif
                            </div>
                            <hr/>
                            <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                                <p>Who uses this computer?</p>
                                @if( $errors->has('user') )
                                    {{ Form::text('user', null, ['id' => 'user', 'class' => 'form-control alert-danger']) }}
                                    {{ $errors->first('user', '<span class="help-block">:message</span>') }}
                                @else
                                    {{ Form::text('user', null, ['id' => 'user', 'class' => 'form-control', 'placeholder' => 'e.g., John Smith']) }}
                                @endif
                            </div>
                            <hr/>
                            <div class="form-group {{ $errors->has('department_id') ? 'has-error' : '' }}">
                                <p>What department is this machine located in?</p>
                                {{ Form::select('department_id', $departments_dropdown , null, ['class' => 'form-control'])}}
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <span class="fa fa-save"></span>
                                            Save Machine Record
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    {{ Form::close() }}
                  </div>
                </div>

            </div>
        </div>

    </section>
@stop