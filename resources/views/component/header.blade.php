<div class="header-div-main">

    <div class="header-div-left">
        <div class="header-title">{{$pageTitle}}</div>
    </div>

    <div class="header-div-right">
        {{-- <div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div> --}}
        <div class="header-contect hide-on-phone">
            <img src="img/smartphone.svg" alt="电话"" class="social-icon vcenter">
            <span class="vcenter social-text">{{$phoneNumber}}</span>
            <img src="img/wechat.svg" alt="电话"" class="social-icon vcenter">
            <span class="vcenter social-text">{{$wechatNumber}}</span>
        </div>

        <div class="show-on-phone">
            <!-- this svg is download from :https://www.iconfinder.com/icons/134216/hamburger_lines_menu_icon -->
            <!-- this svg is create by: Timothy Miller -->
            <a class="nav-burger"></a>
        </div>

        <div class="nav-div-main hide-on-phone" id="nav-menu">
            <nav >
                <ul>
                    <li><a href='#'>主页</a></li>
                    <li><a href='#'>服务项目</a></li>
                    <li><a href='#'>联系方式</a></li>
                    <li><a href='#'>关于</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

@push('style')
.header-contect{
    padding: 5px 10px 5px 10px;
    font-size:12px;
    color:#777;
    text-align: right;
}

.social-text{
    font-size:14px;
}

.social-icon{
    height:13px;
}

.nav-open{
    display: block;
    width:100%;
}

.nav-div-main{
    float:right;
    margin-right:10px;
}

nav ul{
    list-style-type: none;
    padding: 0;
}

nav ul li{
    display: inline-block;
    border: 1px solid lightgray;
    border-radius: 5px;
    margin-bottom: 4px;
}

nav a{
    text-decoration: none;
    display: block;
    padding-left: 10px;
    padding-right: 10px;
}

.nav-burger{
    display:block;
    padding: 0px;
    height: 40px;
    background: url(../img/burger.svg) no-repeat 98% center;
}

.header-div-main{
    display: table; 
    overflow: hidden;
    width:100%;
    background-color:#eee;
}

.header-div-content{
    margin:0 auto;
    display: table-cell; 
    vertical-align: middle;
    background-color:blue;
}

.header-title{
    font-size:24px;
    float:left;
    padding:10px;
    margin: 0 18px;
}

@media screen and (max-width: 465px){
    nav{
        clear:both;
    }

    nav ul{
        background-color:#555;
    }

    nav ul li a{
        color:#fff;
    }

    nav ul li{
        display: block;
        border:none;
        padding: 8px;
        text-align:center;
        border-bottom: 1px solid gray;
    }
    .nav-div-main{
        margin:0;
    }
}

@endpush

@push('script')
    $(document).ready(function(){
        $('.nav-burger').on("click",function(){
            $("#nav-menu").toggleClass("nav-open");
        });
    });
@endpush