@extends('app')
@section('content')
<h2>Insights</h2>
<p>Average Posts Per Day: {{$average_posts_per_day}}</p>
<p>Min Posts Per Day: {{reset($min_posts_per_day)}} on {{key($min_posts_per_day)}}</p>
<p>Max Posts Per Day: {{reset($max_posts_per_day)}} on {{key($max_posts_per_day)}}</p>
@stop