@extends('app')

@section('content')
            <div class="content">
                <div class="title">Welcome</div>
                <div class="quote">Please enter a url below:</div>
                   {!! Form::open(array('url' => '#', 'method' => 'put')) !!}
                   {!! Form::text('first_name') !!}
                   {!! Form::submit() !!}
                   {!! Form::close()!!}
            </div>
        <div style="visibility:hidden;" id="sessionstore"></div>
@stop
