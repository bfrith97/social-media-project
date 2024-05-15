@include('partials.head')
@include('partials.nav')

@include('partials.groups.index')

@push('js')
    <script src="{{ asset('js/groups/join.js') }}"></script>
@endpush

@include('partials.footer')
