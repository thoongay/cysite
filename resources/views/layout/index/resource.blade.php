@extends('layout.html',['title'=>$tagTitle])

@push('js')
<script src="{{asset('js/jquery.min.js')}}"></script>
{{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
<script src="{{asset('js/modernizr-custom.js')}}"></script>
@endpush

@push('css')
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
@endpush

@push('css-var')
:root {
    --small-device-width: 415px;
}

.flex-container{
    display:flex;
}

.clearer{
    height:1px;
    overflow:hidden;
    clear:both;
    margin-top:-1px;
}

.vcenter{
    vertical-align: middle;
}

.hide-on-phone{
    display:block;
}

.show-on-phone{
    display:none;
}

.hide-on-tablet{
    display:block;
}

.show-on-tablet{
    display:none;
}

@media screen and (max-width: 465px){
    
    .hide-on-phone{
        display:none;
    }

    .show-on-phone{
        display:block;
    }
}

@media screen and (max-width: 650px){
    
    .hide-on-tablet{
        display:none;
    }

    .show-on-tablet{
        display:block;
    }
}
@endpush

@push('style')
*{
    margin: 0;
}

body{
    font-size:14px;
    background: #fff;
    font-family: sans-serif;
}
@endpush


