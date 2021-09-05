@extends('LayoutError')

@section('title',  __('Page not found'))

@section('body')
    <h1 class="error-number">404</h1>
    <h2>{{__("Sorry but we couldn't find this page")}}</h2>
    <p>{{__('This page you are looking for does not exist.')}}</p>
@stop
