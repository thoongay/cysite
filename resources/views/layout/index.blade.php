@extends('layout.html',['title'=>$tagTitle])

@push('js')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/modernizr-custom.js')}}"></script>
@endpush

@push('css-var')
:root {
    --small-device-width: 415px;
}

.hide-on-phone{
    display:block;
}

.show-on-phone{
    display:none;
}

@media screen and (max-width: 415px){
    
    .hide-on-phone{
        display:none;
    }

    .show-on-phone{
        display:block;
    }
}
@endpush

@push('style')
*{
    margin: 0;
}

body{
    background: #eee;
}
@endpush


