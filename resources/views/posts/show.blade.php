@include('partials.head')
@include('partials.nav')

@include('partials.posts.show')

@push('js')
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/posts/comment.js') }}"></script>
    <script src="{{ asset('js/posts/like.js') }}"></script>
    <script src="{{ asset('js/follows/join.js') }}"></script>
@endpush

@include('partials.footer')
