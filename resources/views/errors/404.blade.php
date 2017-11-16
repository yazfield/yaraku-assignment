@extends('errors::layout')

@section('title', 'Page Not Found')

@section('message')
  <p>{{ trans('global.errors.404') }}</p>
  <p class="text-center">
    <a href="/" style="text-decoration: none">{{ trans('global.back_home') }}</a>
  </p>
@endsection