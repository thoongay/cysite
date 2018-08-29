@extends('layout.index.headerfooter')

@section('content')
<div class="frame-leftright-wrapper">
    <div class="frame-leftright-div-top">
        @yield('top')
    </div>
    <div class="frame-leftright-div-main">
        <div class="frame-leftright-ldiv">@yield('left')</div>
        <div class="frame-lfetright-rdiv hide-on-tablet">@yield('right')</div>
    </div>
</div>
@endsection

@push('style')

.frame-leftright-div-top{
    width:100%;
}

.frame-leftright-div-main{
    width:100%;
    max-width:960px;
    margin:0 auto;
    display:flex;
}

.frame-leftright-ldiv{
    width:100%;
}

.frame-lfetright-rdiv{
    width:210px;
    flex-shrink: 0;
}

@media screen and (max-width: 650px){
    .frame-leftright-ldiv{
        width:100%;
    }
}
    
@endpush