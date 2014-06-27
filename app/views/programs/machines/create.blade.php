@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('programs.index') }}"><i class="fa fa-dot-circle-o"></i> Programs</a></li>
          <li><a href="{{ route('programs.machines.index', $program->id) }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li class="active"><span class="badge">{{ $program->publisher->name }}</span> {{ $program->name }} </li>
          <li class="active">Assign</li>
        </ol>

        <div class="page-header">
            <h1>Assign <small>Machine</small></h1>
            <p>Assign machine to <span class="badge">{{ $program->publisher->name }}</span> <strong>{{ $program->name }}</strong>.</p>
        </div>

        @if( ! count( $machines_dropdown ) )
          <div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            There are currently no machines available to assign this program to. To add a new machine <a class="btn btn-success btn-xs" href="{{ route('machines.create') }}">click here</a>.
          </div>
        @else
          <div class="row">
              <div class="col-lg-6">
                <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading"><i class="fa fa-plus"></i> Assign Machine to Program</div>
                  <div class="panel-body">
                    {{ Form::open(['role' => 'form', 'route' => ['programs.machines.store', $program->id]] ) }}
                        <fieldset>
                            <div class="form-group {{ $errors->has('machine_id') ? 'has-error' : '' }}">
                                <p>Select the machine you want to assign this program to:</p>
                                {{ Form::select('machine_id', $machines_dropdown , null, ['class' => 'form-control'])}}
                                {{ Form::hidden('program_id', $program->id) }}
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <span class="fa fa-save"></span>
                                            Assign Machine
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