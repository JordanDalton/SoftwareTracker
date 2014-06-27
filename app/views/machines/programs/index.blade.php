@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li><a href="{{ route('machines.programs.index', $machine->id) }}">{{  $machine->mac_address }}</a></li>
          <li class="active">Programs</li>
        </ol>

        @foreach( ['program_attached', 'program_detached'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="page-header">
            <h1>{{ $machine->mac_address }} <small>Programs</small></h1>
            <p><span class="label label-default"><i class="fa fa-users"></i> {{ $machine->department->name or 'N/A' }}</span> <span class="label label-info"><i class="fa fa-user"></i> {{ $machine->user }}</span> <span class="label label-info"><i class="fa fa-exchange"></i> {{ $machine->rarp() }}</span></p>
        </div>

        <a class="btn btn-success" href="{{ route('machines.programs.create', $machine->id)}}"><i class="fa fa-share"></i> Assign Program</a>
        <hr/>
        <p>The following programs have been installed on this machine.</p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr class="btn-info">
                    <th class="centered-text">Detach</th>
                    <th>Program Name</th>
                    <th>Publisher</th>
                </tr>
            </thead>
            <tbody>
                {{-- Handle when there no records to display. --}}
                @if( ! count( $programs ) )
                <tr>
                    <td colspan="3">There are currently no programs to list.</td>
                </tr>
                @endif
                {{-- Loop through the available records. --}}
                @foreach( $programs as $program )
                <tr>
                    <td class="centered-text">
                        <a class="btn btn-danger btn-xs" href="{{ route('machines.programs.detach', $machine->id, $program->id) }}">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </td>
                    <td>
                        <strong>{{ $program->name }}</strong>
                    </td>
                    <td>
                        <a href="{{ route('publishers.show', $program->publisher->id) }}">
                             <span class="underlined">{{ $program->publisher->name }}</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Only show pagination if neccessary. --}}
        @if( display_pagination( $programs ) )
            <div class="panel-body">
                {{ $programs->links() }}
            </div>
        @endif

    </section>
@stop