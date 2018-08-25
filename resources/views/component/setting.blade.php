@if($type=='text')
<input style="width:100%;" type="text" name="{{$name}}[]" value="{{$content or ''}}">
@endif

@if($type=='textarea')
<textarea style="width:100%;" name="{{$name}}[]" rows="5">{{$content or ''}}</textarea>
@endif

@if($type=='checkbox')
<?php 
$options=explode(",",$option);
$contents=explode(",",$content);
?>
@foreach($options as $o)
<div style="display:inline-block;">
    <input type="checkbox" name="{{$name}}[]" 
        value="{{$o}}" id="{{$name.$o}}"
        @if(in_array($o,$contents))
            checked
        @endif
        />
    <label for="{{$name.$o}}">{{$o}}</label>
</div>
@endforeach
@endif
