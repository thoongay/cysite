@extends('layout.html',['title'=>'Login'])

@include('component.app')

@section('body')
<div class="login-div">
    <div class="login-title">登录</div>
    @include('component.errormsg',['errors'=>$errors])
    <form action="" method="post">
        {{csrf_field()}}
        <div><input type="text" name="user" placeholder="用户名" ></div>
        <div><input type="password" name="password" placeholder="密码" ></div>
        <div>
            <input type="text" name="captcha" placeholder="验证码" 
                style="width:150px;vertical-align: top;" >
            <img src="{{url('admin/captcha')}}" data-url="{{url('admin/captcha')}}"
                class="login-captcha-img">
        </div>
        <div><input type="submit" value="登录" class="btn btn-primary"></div>
    </form>
</div>
@endsection

@push('script')
$('body').on('click','.login-captcha-img',function(){
    $(this).attr('src',$(this).data('url') + '?id=' + Math.random());
 });
@endpush

@push('style')
.login-div{
    text-align: center;
    width:300px;
    margin:20px auto;
    border: 1px solid lightgray;
    border-radius:5px;
}

.login-div input{
    border:1px solid lightgray;
    width:250px;
    margin:5px;
    border-radius:5px;    
}

.login-captcha-img{
    margin: 5px;
    width: 84px;
    border:1px solid lightgray;
    height:26px;
    border-radius:5px;
}

.login-captcha-input{
    width:140px;
    height:24px;
}

.login-title{
    font-weight: bold;
    font-size: 24px;
    color: grey;
}
@endpush