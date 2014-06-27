@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('departments.index') }}"><i class="fa fa fa-users"></i> Departments</a></li>
          <li class="active"><i class="fa fa-pencil"></i> Edit</li>
        </ol>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading"><i class="fa fa-pencil"></i> Edit Department Record</div>
                  <div class="panel-body">
                    {{ Form::model( $department , ['method' => 'PATCH', 'role' => 'form', 'route' => ['departments.update', $department->id]] ) }}
                        <fieldset>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <p>What is the name of the department?</p>
                                @if( $errors->has('name') )
                                    {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control alert-danger']) }}
                                    {{ $errors->first('name', '<span class="help-block">:message</span>') }}
                                @else
                                    {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'e.g., Shipping']) }}
                                @endif
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <span class="fa fa-save"></span>
                                            Update Department Record
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