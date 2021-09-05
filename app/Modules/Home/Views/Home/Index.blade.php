@extends('Layout')

@section('title', 'CV - Fresher PHP Laravel')

@section('css')
    <link rel="stylesheet" href="/css/home/home/profile.css" type="text/css" media="all"/>
@stop

@section('scripts')
    <script src="/js/home/home/service.js" type="text/javascript"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
@stop

@section('body')
    @include('Home::Home.Profile')
@stop
