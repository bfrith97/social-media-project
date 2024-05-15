@include('partials.head')
@include('partials.nav')

@include('partials.groups.show')

@push('js')
    <script src="{{ asset('js/groups/join.js') }}"></script>
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/posts/comment.js') }}"></script>
    <script src="{{ asset('js/posts/like.js') }}"></script>
@endpush

@include('partials.footer')
