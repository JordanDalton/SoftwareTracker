@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('programs.index') }}"><i class="fa fa-dot-circle-o"></i> Programs</a></li>
        </ol>

        @foreach( ['program_added', 'program_deleted', 'program_updated'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <i class="fa fa-dot-circle-o"></i> Program List 
            </div>
            <div class="panel-body bg-crossword">
                <div class="col-md-3">
                    <a class="btn btn-success btn-block" href="{{ route('programs.create') }}"><i class="fa fa-plus"></i> <strong>Add Program</strong></a>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="btn-info">
                        <th class="centered-text">Edit</th>
                        <th>Program Name</th>
                        <th>Publisher</th>
                        <th>Installs</th>
                        <th class="centered-text">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Handle when there no records to display. --}}
                    @if( ! count( $programs ) )
                    <tr>
                        <td colspan="4">There are currently no programs to list.</td>
                    </tr>
                    @endif
                    {{-- Loop through the available records. --}}
                    @foreach( $programs as $program )
                    <tr>
                        <td class="centered-text">
                            <a class="btn btn-default btn-xs" href="{{ route('programs.edit', $program->id) }}">
                                <i class="fa fa-pencil"></i>
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
                        <td>
                            <a href="{{ route('programs.show', $program->id) }}">
                                <span class="badge">{{ $program->machines->count() }}</span> 
                                <span class="underlined">Installs</span>
                            </a>
                        </td>
                        <td class="centered-text">
                            <a class="btn btn-danger btn-xs" href="{{ route('programs.delete', $program->id) }}">
                                <i class="fa fa-times"></i>
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

        </div>
    </section>
@stop