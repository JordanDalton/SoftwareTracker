@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('publishers.index') }}"><i class="fa fa-building-o"></i> Publishers</a></li>
          <li class="active">{{ $publisher->name }} </li>
        </ol>

        <div class="page-header">
            <h1>{{ $publisher->name }} <small>Programs</small></h1>
            <p>The following programs are published by <strong>{{ $publisher->name }}</strong>.</p>
        </div>

        <a class="btn btn-success" href="{{ route('programs.create', ['publisher' => $publisher->id]) }}"><i class="fa fa-plus"></i> Add Program to {{ $publisher->name }}</a>
        <hr/>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="btn-info">
                    <th class="centered-text">Edit</th>
                    <th>Publisher</th>
                    <th>Programs</th>
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
                        <a class="btn btn-xs btn-default" href="{{ route('programs.edit', $program->id) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <strong>{{ $program->name }}</strong>
                    </td>
                    <td>
                        <a href="{{ route('programs.show', $program->id) }}">
                            <span class="badge">{{ $program->machines->count() }}</span> 
                            <span class="underlined">{{ Lang::choice('Installation|Installations', $program->machines->count(), array()) }}</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Only show pagination if neccessary. --}}
        @if( display_pagination( $programs ) )
            {{ $programs->links() }}
        @endif

    </section><!-- .container -->
@stop