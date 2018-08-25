@extends('layout.html',['title'=>isset($pageTitle)?$pageTitle:'Admin'])

@push('js')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/modernizr-custom.js')}}"></script>
@endpush

@push('css')
<link href="{{asset('css/index.css')}}" rel="stylesheet">
@endpush


