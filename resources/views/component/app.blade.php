@push('meta')
{{-- app.js need this --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">    
@endpush

@push('js')
<script src="{{asset('js/app.js')}}"></script>
@endpush