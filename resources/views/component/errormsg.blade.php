@push('style')
.div-error-message{
    border-radius: 5px;
    padding: 5px 15px;
    color:darkgoldenrod;
    background: lightgoldenrodyellow;
    margin: 5px auto;
}
@endpush

@if(isset($errors))
    @if(is_object($errors))
        @if(count($errors)>0)
            @foreach($errors->all() as $error)
                <div class="div-error-message">
                    {{$error}}
                </div>
            @endforeach
        @endif
    @else
        <div class="div-error-message">
            {{$errors}}
        </div>
    @endif
@endif