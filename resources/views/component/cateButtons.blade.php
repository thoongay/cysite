@foreach($cates as $c)
    <a href="{{url("category/".$c)}}">{{$c}}</a>
@endforeach