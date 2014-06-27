@extends('layouts.default')

@section('content')
    <section class="container">
        <ol class="breadcrumb">
          <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a></li>
        </ol>
        <div class="jumbotron">
            <h1>Software <strong>Tracker</strong></h1>
            <p>Tracking of commercial software installations within the WRS network.</p>
        </div>
    </section>
@stop