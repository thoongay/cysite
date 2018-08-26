<div class="nav-div-main">
    <nav>
        <div class="nav-div-burger show-on-phone">
            <!-- this svg is download from :https://www.iconfinder.com/icons/134216/hamburger_lines_menu_icon -->
            <!-- this svg is create by: Timothy Miller -->
            <div class="nav-div-page-title">{{$pageTitle}}</div><a class="nav-burger"></a>
        </div>
        <div class="nav-category hide-on-phone">
            <ul>
                <li ><a href='#'>主页</a></li>
                @foreach($cates as $cate)
                    <li><a href='#'>{{$cate}}</a></li>
                @endforeach
                <li><a href='#'>关于</a></li>
            </ul>
        </div>
    </nav>
</div>

@push('style')
.nav-div-page-title{
    display:inline-block;
    float: left;
    font-size: 20px;
    padding: 5px 5px;
}
.nav-div-main{
    margin:0 auto;
    max-width:960px;
    min-height:30px;
}

nav{
    background: #333;    
}

nav ul{
    list-style-type: none;
    padding: 0;
}

nav ul li{
    display: inline-block;
}

nav a{
    text-decoration: none;
    color: #fff;
    display: block;
    padding: 10px;
    display: block;
}

.nav-open{
    display: block;
}

.nav-div-burger{
    background-color: #eee;
    width:100%;
}

.nav-burger{
    padding: 0px;
    height: 40px;
    background: url(../img/burger.svg) no-repeat 98% center;
}

@media screen and (max-width: 415px){
    nav ul li{
        display: list-item;
        text-align:center;
        border-bottom: 1px solid gray;
    }
}
@endpush

@push('script')
    $(document).ready(function(){
        $('.nav-burger').on("click",function(){
            $(".nav-category").toggleClass("nav-open");
        });
    });
@endpush