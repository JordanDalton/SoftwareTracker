@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('publishers.index') }}"><i class="fa fa-building-o"></i> Publishers</a></li>
          <li class="active"><i class="fa fa-pencil"></i> Create</li>
        </ol>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading"><i class="fa fa-pencil"></i> Create New Publisher Record</div>
                  <div class="panel-body">
                    {{ Form::model( $publisher , ['role' => 'form', 'route' => 'publishers.store'] ) }}
                        <fieldset>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <p>What is the publisher's company name?</p>
                                @if( $errors->has('name') )
                                    {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control alert-danger']) }}
                                    {{ $errors->first('name', '<span class="help-block">:message</span>') }}
                                @else
                                    {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'e.g., Microsoft']) }}
                                @endif
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <button class="btn btn-primary btn-block" type="submit">
                                            <span class="fa fa-save"></span>
                                            Save Publisher Record
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