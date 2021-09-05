@extends('LayoutError')

@section('title',  __('Access denied'))

@section('body')
    <h1 class="error-number">403</h1>
    <h2>{{__("Access denied")}}</h2>
    <p>{{__('Full authentication is required to access this resource.')}}</p>
@stop
