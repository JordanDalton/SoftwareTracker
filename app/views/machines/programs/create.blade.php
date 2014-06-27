@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li><a href="{{ route('machines.show', $machine->id) }}">{{  $machine->mac_address }}</a></li>
          <li><a href="{{ route('machines.programs.index', $machine->id) }}"><i class="fa fa-dot-circle-o"></i> Programs</a></li>
          <li class="active">Assign</li>
        </ol>

        <div class="page-header">
            <h1>Assign <small>Program</small></h1>
            <p>Assign program to <strong>{{ $machine->mac_address }}</strong>.</p>
        </div>

        @if( ! count($programs_dropdown) )
          <div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            There are currently no available programs that can be installed on this machine.
          </div>
        @else
          <div class="row">
              <div class="col-lg-6">
                  <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading"><i class="fa fa-plus"></i> Assign Program to Machine</div>
                    <div class="panel-body">
                      {{ Form::open(['role' => 'form', 'route' => ['machines.programs.store', $machine->id]] ) }}
                          <fieldset>
                              <div class="form-group {{ $errors->has('program_id') ? 'has-error' : '' }}">
                                  <p>Select the program you want to assign:</p>
                                  {{ Form::select('program_id', $programs_dropdown , null, ['class' => 'form-control'])}}
                                  {{ Form::hidden('machine_id', $machine->id) }}
                              </div>
                              <hr/>
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col-md-5 col-sm-5 col-xs-5">
                                          <button class="btn btn-primary btn-block" type="submit">
                                              <span class="fa fa-save"></span>
                                              Assign Program
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
        @endif

    </section>
@stop