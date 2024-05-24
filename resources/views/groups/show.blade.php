@include('partials.head')
@include('partials.nav')

@include('partials.groups.show')

@push('js')
    <script src="{{ asset('js/groups/join.js') }}"></script>
    <script src="{{ asset('js/posts/post.js') }}"></script>
    <script src="{{ asset('js/shared/comment.js') }}"></script>
    <script src="{{ asset('js/shared/like.js') }}"></script>
    <script src="{{ asset('js/profile/follow.js') }}"></script>
@endpush

@include('partials.footer')
