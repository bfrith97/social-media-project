@include('partials.head')
@include('partials.nav')

@include('partials.posts.index')

@push('js')
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/posts/comment.js') }}"></script>
    <script src="{{ asset('js/posts/post-like.js') }}"></script>
    <script src="{{ asset('js/follows/follow.js') }}"></script>
@endpush

@include('partials.footer')
