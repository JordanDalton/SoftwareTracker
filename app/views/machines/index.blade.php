@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
        </ol>

        @foreach( ['machine_added', 'machine_deleted', 'machine_updated'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <i class="fa fa-desktop"></i> Machine List 
                    </div>
                    <div class="panel-body bg-crossword">
                        <div class="col-md-3">
                            {{ Form::open(['class' => 'form-inline', 'method' => 'GET', 'role' => 'form']) }}
                                <div class="form-group has-feedback">
                                    {{ Form::text('criteria', Input::query('criteria'), ['class' => 'form-control', 'placeholder' => 'Enter search criteria.']) }}
                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-success btn-block" href="{{ route('machines.create') }}"><i class="fa fa-plus"></i> <strong>Add Machine</strong></a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="btn-info">
                                <th class="centered-text">Edit</th>
                                <th>MAC Address</th>
                                <th>Last Known IP</th>
                                <th>Machine User &amp; Location</th>
                                <th>Installed Software</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Handle when there no records to display. --}}
                            @if( ! count( $machines ) )
                            <tr>
                                <td colspan="3">There are currently no machines to list.</td>
                            </tr>
                            @endif
                            {{-- Loop through the available records. --}}
                            @foreach( $machines as $machine )
                            <tr>
                                <td class="centered-text">
                                    <a class="btn btn-default btn-xs" href="{{ route('machines.edit', $machine->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td>
                                    <strong>{{ $machine->mac_address }}</strong>
                                </td>
                                <td>{{ $machine->rarp() }}</td>
                                <td>{{ $machine->user }} <span class="badge">{{ $machine->department->name or 'N/A' }}</span></td>
                                <td><a href="{{ route('machines.show', $machine->id) }}"><span class="badge">{{ $machine->programs->count() }}</span> <span class="underlined">{{ Lang::choice('Installation|Installations', $machine->programs->count(), array()) }}</span></a></td>
                                <td class="centered-text">
                                    <a class="btn btn-danger btn-xs" href="{{ route('machines.delete', $machine->id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Only show pagination if neccessary. --}}
                    @if( display_pagination( $machines ) )
                        <div class="panel-body">
                            {{ $machines->links() }}
                        </div>
                    @endif

                </div><!-- .panel panel-default -->
            </div><!-- .col-md-6 -->
        </div><!-- .row -->
    </section><!-- .container -->
@stop