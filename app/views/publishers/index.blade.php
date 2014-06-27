@extends('layouts.default')

@section('content')
    <section class="container">

        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('publishers.index') }}"><i class="fa fa-building-o"></i> Publishers</a></li>
        </ol>

        @foreach( ['publisher_added', 'publisher_deleted', 'publisher_updated'] as $flash )
            @if( Session::has( $flash ) )
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    {{ Session::get( $flash ) }}
                </div>
            @endif
        @endforeach

        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <i class="fa fa-building-o"></i> Publisher List 
                    </div>
                    <div class="panel-body bg-crossword">
                        <div class="col-md-4">
                            <a class="btn btn-success btn-block" href="{{ route('publishers.create') }}">
                                <i class="fa fa-plus"></i> 
                                <strong>Add Publisher</strong>
                            </a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="btn-info">
                                <th class="centered-text">Edit</th>
                                <th>Publisher</th>
                                <th>Programs</th>
                                <th class="centered-text">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Handle when there no records to display. --}}
                            @if( ! count( $publishers ) )
                            <tr>
                                <td colspan="3">There are currently no publishers to list.</td>
                            </tr>
                            @endif
                            {{-- Loop through the available records. --}}
                            @foreach( $publishers as $publisher )
                            <tr>
                                <td class="centered-text">
                                    <a class="btn btn-xs btn-default" href="{{ route('publishers.edit', $publisher->id) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td>
                                    <strong>{{ $publisher->name }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('publishers.show', $publisher->id) }}">
                                        <span class="badge">{{ $publisher->programs->count() }}</span> 
                                        <span class="underlined">{{ Lang::choice('Program|Programs', $publisher->programs->count(), array()) }}</span>
                                    </a>
                                </td>
                                <td class="centered-text">
                                    <a class="btn btn-danger btn-xs" href="{{ route('publishers.delete', $publisher->id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Only show pagination if neccessary. --}}
                    @if( display_pagination( $publishers ) )
                        <div class="panel-body">
                            {{ $publishers->links() }}
                        </div>
                    @endif

                </div><!-- .panel panel-default -->
            </div><!-- .col-md-6 -->
        </div><!-- .row -->
    </section><!-- .container -->
@stop