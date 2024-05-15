@include('partials.head')
@include('partials.nav')

@include('partials.profiles.show')

@push('js')
    <script src="{{ asset('js/profile/tabs.js') }}"></script>
    <script src="{{ asset('js/profile/join.js') }}"></script>
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/posts/comment.js') }}"></script>
    <script src="{{ asset('js/posts/like.js') }}"></script>
@endpush

@include('partials.footer')

