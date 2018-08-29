<!-- 本页面的回到顶部代码复制自以下网址 -->
<!-- https://www.w3schools.com/howto/howto_js_scroll_to_top.asp -->

<div class="header-div-main">
    <div class="header-div-left">
        <div class="header-title">{{$pageTitle}}</div>
    </div>
    <div class="header-div-right">
        <div class="nav-div-main hide-on-phone">
           @include('component.nav')
        </div>
        <div class="show-on-phone">
            <!-- this svg is download from :https://www.iconfinder.com/icons/134216/hamburger_lines_menu_icon -->
            <!-- this svg is create by: Timothy Miller -->
            <a class="nav-burger"></a>
        </div>
    </div>
</div>
<div class="nav-div-phone show-on-phone nav-close" id="nav-menu">
    @include('component.nav')
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

@push('style')
#myBtn {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed/sticky position */
    bottom: 20px; /* Place the button at the bottom of the page */
    right: 30px; /* Place the button 30px from the right */
    z-index: 99; /* Make sure it does not overlap */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color: darkcyan; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    padding: 15px; /* Some padding */
    border-radius: 10px; /* Rounded corners */
    font-size: 18px; /* Increase font size */
}

#myBtn:hover {
    background-color: #555; /* Add a dark-grey background on hover */
}

.nav-open{
    display: block;
}

.nav-close{
    display:none;
}

.nav-div-main{
    display: block;
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
    display: block;
    font-size: 15px;
    color: darkcyan;
    font-weight:bold;
    padding-left: 10px;
    padding-right: 10px;
}

.nav-burger{
    padding: 0px;
    display:block;
    width:40px;
    height:40px;
    background: url(../img/burger.svg) no-repeat 98% center;
}

.header-div-main{
    box-shadow: 0px 1px 5px lightgrey;
    top:0px;
    position: fixed;
    display: flex; 
    width:100%;
    background-color:#eee;
}

.header-div-left{
    width:100%;
}

.header-div-right{
    width:300px;
    flex-shrink:0;
    display: flex;
    justify-content: center;
    align-items: center; 
}

.header-title{
    font-size:24px;
    float:left;
    padding:8px 10px 8px 20px;
}

.nav-div-phone{
    position: fixed;
    width: 100%;
}

@media screen and (max-width: 465px){
    .nav-div-main{
        display:none;
    }
    .header-div-right{
        width:50px;
    }

    .nav-div-phone nav ul li{
        display: block;
        border:none;
        padding: 8px;
        text-align:center;
        border-bottom: 1px solid gray;
        background-color:#555;
    }

    .nav-div-phone nav ul li a{
        color:#fff;
    }
}

@endpush

@push('script')
    $(document).ready(function(){
        $('.nav-burger').on("click",function(){
            $("#nav-menu").toggleClass("nav-close");
        });

       
    });

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("myBtn").style.display = "block";
        } else {
            document.getElementById("myBtn").style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
@endpush