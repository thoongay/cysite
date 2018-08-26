<div class="footer-div-main flex-container">
    <div class="footer-qna">
        <dl>
            <dt>常见问题</dt>
            <dd>问题1</dd>
            <dd>问题1</dd>
            <dd>问题1</dd>
            <dd>问题1</dd>
        </dl>
    </div>

    <div class="footer-service">
        <dl>
            <dt>产品服务</dt>
            <dd>服务1</dd>
            <dd>服务1</dd>
            <dd>服务1</dd>
        </dl>
    </div>

    <div class="footer-contect">
        <dl>
            <dt>与我联系</dt>
            <dd>手机: 1234 </dd>
            <dd>QQ: 1234</dd>
            <dd>邮件:a@a.abc</dd>
            <dd>微信</dd>
        </dl>
    </div>
    
</div>

@push('style')
.footer-qna{
    flex-grow:2;
    min-width:180px;
}
.footer-contect{
    flex-grow:3;
    min-width:220px;
}
.footer-service{
    flex-grow:2;
    min-width:180px;
}
.footer-div-main{
    width:100%;
    flex-wrap:wrap;
    background-color: darkslategrey;
    color: lightgray;
    padding: 20px;
}

.footer-div-main dt{
    font-weight:bold;
}

.footer-div-main dd{
    font-weight:normal;
}
@endpush

@push('script')
   
@endpush