@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('departments.index') }}"><i class="fa fa fa-users"></i> Departments</a></li>
          <li><a href="{{ route('departments.show', $department->id) }}">{{  $department->name }}</a></li>
          <li><a href="{{ route('departments.machines.index', $department->id) }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li class="active">Assign</li>
        </ol>

        <div class="page-header">
            <h1>Assign <small>Machine</small></h1>
            <p>Assign machine to <strong>{{ $department->name }}</strong>.</p>
        </div>

       @if( ! count($machines_dropdown) )
          <div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            There are currently no available machines that can be assigned to this department.
          </div>
        @else
          <div class="row">
              <div class="col-lg-6">
                  <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading"><i class="fa fa-plus"></i> Assign Machine to Department</div>
                    <div class="panel-body">
                      {{ Form::open(['role' => 'form', 'route' => ['departments.machines.store', $department->id]] ) }}
                          <fieldset>
                              <div class="form-group {{ $errors->has('program_id') ? 'has-error' : '' }}">
                                  <p>Select the machine you want to assign:</p>
                                  {{ Form::select('machine_id', $machines_dropdown , null, ['class' => 'form-control'])}}
                                  {{ Form::hidden('department_id', $department->id) }}
                              </div>
                              <hr/>
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col-md-5 col-sm-5 col-xs-5">
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