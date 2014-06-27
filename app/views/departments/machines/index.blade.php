@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('departments.index') }}"><i class="fa fa fa-users"></i> Departments</a></li>
          <li class="active">{{ $department->name }} </li>
        </ol>

        @foreach( ['machine_detached'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="page-header">
            <h1>{{ $department->name }} <small>Computers</small></h1>
            <p>The following computers are part of the <strong>{{ $department->name }}</strong> department.</p>
        </div>

        <a class="btn btn-success" href="{{ route('departments.machines.create', $department->id)}}"><i class="fa fa-share"></i> Assign Machine</a>
        <hr/>

        <div class="row">
            <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="btn-info">
                                <th class="centered-text">Edit</th>
                                <th>MAC Address</th>
                                <th>Last Known IP</th>
                                <th>Machine User &amp; Location</th>
                                <th>Installed Software</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Handle when there no records to display. --}}
                            @if( ! count( $machines ) )
                            <tr>
                                <td colspan="5">There are currently no machines to list.</td>
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
                                <td>{{ $machine->user or 'Not Specified' }} <span class="badge">{{ $machine->department->name }}</span></td>
                                <td><a href="{{ route('machines.show', $machine->id) }}"><span class="badge">{{ $machine->programs->count() }}</span> <span class="underlined">Installations</span></a></td>
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
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </section><!-- .container -->
@stop