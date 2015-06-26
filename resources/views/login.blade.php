@extends('app')

@section('content')
<h2>Hello</h2>
<div id="alertContainer">
</div>
<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
<fb:login-button scope="public_profile,email,manage_pages,read_insights" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">

@stop