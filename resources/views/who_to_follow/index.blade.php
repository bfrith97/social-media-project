@include('partials.head')
@include('partials.nav')

@include('partials.who_to_follow.index')

@push('js')
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endpush

@include('partials.footer')
