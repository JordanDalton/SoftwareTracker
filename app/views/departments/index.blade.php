@extends('layouts.default')

@section('content')
    <section class="container">
        
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="{{ route('departments.index') }}"><i class="fa fa-users"></i> Departments</a></li>
        </ol>

        @foreach( ['department_added', 'department_deleted', 'department_updated'] as $flash )
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
                <i class="fa fa-users"></i> Department List 
            </div>
            <div class="panel-body bg-crossword">
                <div class="col-md-3">
                    <a class="btn btn-success btn-block" href="{{ route('departments.create') }}"><i class="fa fa-plus"></i> <strong>Add Department</strong></a>
                </div>
            </div>
            <table class="table table-bordered table-striped" style='border-bottom:1px solid #eee'>
                <thead>
                    <tr class="btn-info">
                        <th class="centered-text">Edit</th>
                        <th>Name</th>
                        <th>Computer(s)</th>
                        <th class="centered-text">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Handle when there no records to display. --}}
                    @if( ! count( $departments ) )
                    <tr>
                        <td colspan="4">There are currently no departments to list.</td>
                    </tr>
                    @endif
                    {{-- Loop through the available records. --}}
                    @foreach( $departments as $department )
                    <tr>
                        <td class="centered-text">
                            <a class="btn btn-default btn-xs" href="{{ route('departments.edit', $department->id) }}">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <strong>{{ $department->name }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('departments.show', $department->id) }}">
                                <span class="badge">{{ count($department->machines) }}</span> 
                                <span class="underlined">{{ Lang::choice('Computer|Computers', count($department->machines), array()) }}</span>
                            </a>
                        </td>
                        <td class="centered-text">
                            <a class="btn btn-danger btn-xs" href="{{ route('departments.delete', $department->id) }}">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Only show pagination if neccessary. --}}
            @if( display_pagination( $departments ) )
                <div class="panel-body">
                    {{ $departments->links() }}
                </div>
            @endif
        </div>
    </section>
@stop