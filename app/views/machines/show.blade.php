@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('machines.index') }}"><i class="fa fa-desktop"></i> Machines</a></li>
          <li class="active">{{ $machine->mac_address }}</li>
        </ol>

        <div class="page-header">
            <h1>{{ $machine->mac_address }} <small>Programs</small></h1>
            <p>The last known IP address for this machine is: <span class="label label-info">{{ $machine->rarp() }}</span></p>
        </div>

        <p>The following programs have been installed on this machine.</p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr class="btn-info">
                    <th class="centered-text">Remove</th>
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
                        <a class="btn btn-danger btn-xs" href="{{ route('programs.destroy', $program->id) }}">
                            <i class="fa fa-times"></i>
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