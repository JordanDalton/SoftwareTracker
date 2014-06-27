@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('programs.index') }}"><i class="fa fa-dot-circle-o"></i> Programs</a></li>
          <li class="active"><span class="badge">{{ $program->publisher->name }}</span> {{ $program->name }} </li>
        </ol>

        @foreach( ['program_detached'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="page-header">
            <h1>{{ $program->name }} <small>Installs</small></h1>
            <p>The following computers have <strong>{{ $program->name }}</strong> installed on them.</p>
        </div>

        <a class="btn btn-success" href="{{ route('programs.machines.create', $program->id)}}"><i class="fa fa-share"></i> Assign Machine</a>
        <hr/>

        <table class="table table-bordered table-striped">
            <thead>
                <tr class="btn-info">
                    <th class="centered-text">Detach</th>
                    <th>MAC Address</th>
                    <th>Last Known IP</th>
                    <th>Machine User &amp; Location</th>
                </tr>
            </thead>
            <tbody>
                {{-- Handle when there no records to display. --}}
                @if( ! count( $machines ) )
                <tr>
                    <td colspan="4">There are currently no machines to list.</td>
                </tr>
                @endif
                {{-- Loop through the available records. --}}
                @foreach( $machines as $machine )
                <tr>
                    <td class="centered-text">
                        <a class="btn btn-danger btn-xs" href="{{ route('machines.programs.detach', [$machine->id, $program->id]) }}">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </td>
                    <td>
                        <strong>{{ $machine->mac_address }}</strong>
                    </td>
                    <td>{{ $machine->rarp() }}</td>
                    <td>{{ $machine->user }} <span class="badge">{{ $machine->department->name or 'N/A' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Only show pagination if neccessary. --}}
        @if( display_pagination( $machines ) )
            {{ $machines->links() }}
        @endif

    </section>
@stop