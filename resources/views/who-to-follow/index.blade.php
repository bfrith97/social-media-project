@include('partials.head')
@include('partials.nav')

@include('partials.who-to-follow.index')

@push('js')
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endpush

@include('partials.footer')
