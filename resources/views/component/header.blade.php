<div class="header-div-main hide-on-phone">
    <div class="header-div-content">
        <p class="header-title">{{$pageTitle}}</p>
    </div>
</div>

@push('style')
.header-div-content{
    margin:0 auto;
    background-color:blue;
    max-width:960px;
    min-height:80px;
}

.header-div-main{
    width:100%;    
    background-color:red;
}

.header-title{
    font-size:24px;
}
    
@endpush