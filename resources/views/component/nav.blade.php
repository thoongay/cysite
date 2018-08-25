<nav>
    <!-- this svg is download from :https://www.iconfinder.com/icons/134216/hamburger_lines_menu_icon -->
    <!-- this svg is create by: Timothy Miller -->
    <a class="burger-nav"></a>
    <ul>
        <li><a href='#'>Home</a></li>
        @foreach($cates as $cate)
            <li><a href='#'>{{$cate}}</a></li>
        @endforeach
        <li><a href='#'>About</a></li>

    </ul>
</nav>

@push('style')
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

.burger-nav{
    display: none;
    padding: 0px;
    background-color: #333;
}

@media screen and (max-width: 400px){
    .burger-nav{
        display: block;
        height: 40px;
        width:100%;
        background: url(../img/burger.svg) no-repeat 98% center;
        background-color: white;
    }

    nav ul{
        display: none;
    }

    nav ul li{
        display: list-item;
        text-align:center;
        border-bottom: 1px solid gray;
    }
}
@endpush

@push('script')
    $(document).ready(function(){
        $('.burger-nav').on("click",function(){
            $("nav ul").toggleClass("nav-open");
        });
    });
@endpush