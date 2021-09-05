@extends('LayoutError')

@section('title',  __('Error'))

@section('body')
    <h1 class="error-number">{{__('Oops')}}!</h1>
    <h2>{{__('An error occurred while processing your request')}}</h2>
    <p>
        {{$error}}
    </p>
@stop
