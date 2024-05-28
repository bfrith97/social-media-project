@include('partials.head')
@include('partials.nav')

@push('js')
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
@endpush

@include('partials.messages.index')

@include('partials.footer')
