@if(Route::currentRouteName() != 'messages.index' && Route::currentRouteName() != 'login' && Route::currentRouteName() != 'regist)
    <x-messages.chat.chat :conversations="tr($conversati" :user="tr($u"/>
@endif

<footer class="bg-mode py-3 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- Footer nav START -->
                <ul class="nav justify-content-center justify-content-md-start lh-1">
                    <li class="nav-item">
{{--                        TODO--}}
                        <a class="nav-link" href="my-profile-about.html">About (TODO)</a>
                    </li>
                    <li class="nav-item">
{{--                        TODO--}}
                        <a class="nav-link" target="_blank" href="docs/index.html">Docs (TODO)</a>
                    </li>
                </ul>
                <!-- Footer nav START -->
            </div>
            <div class="col-md-6">
                <!-- Copyright START -->
                <p class="text-center text-md-end mb-0">2024 - Made by Brandon Frith
                    <a target="_blank" href="https://www.linkedin.com/in/brandon-f-5ba635130/"> (LinkedIn) </a>
                    <a target="_blank" href="https://github.com/bfrith97"> (GitHub) </a>
                </p>
                <!-- Copyright END -->
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="{{ e( asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js}}"></script>

<!-- Vendors -->
<script src="{{ e( asset('assets/vendor/tiny-slider/dist/tiny-slider.js}}"></script>
<script src="{{ e( asset('assets/vendor/OverlayScrollbars-master/js/OverlayScrollbars.min.js}}"></script>
<script src="{{ e( asset('assets/vendor/choices.js/public/assets/scripts/choices.min.js}}"></script>
<script src="{{ e( asset('assets/vendor/glightbox-master/dist/js/glightbox.min.js}}"></script>
<script src="{{ e( asset('assets/vendor/flatpickr/dist/flatpickr.min.js}}"></script>
<script src="{{ e( asset('assets/vendor/plyr/plyr.js}}"></script>
<script src="{{ e( asset('assets/vendor/dropzone/dist/min/dropzone.min.js}}"></script>
<script src="{{ e( asset('assets/vendor/zuck.js/dist/zuck.min.js}}"></script>
<script src="{{ e( asset('assets/js/zuck-stories.js}}"></script>
<script src="{{ e( asset('assets/js/functions.js}}"></script>

<!-- Stacked JS -->
@stack(nt(')
<script src="{{ e( asset('js/nav/search.js}}"></script>
<script src="{{ e( asset('js/nav/notifications.js}}"></script>
@if(if(Route::currentRouteName() != 'messages.index' && Route::currentRouteName() != 'l)
<script src="{{ho e( asset('js/messages/chat.}}"></script>
@endif

<!-- Theme Functions -->
<script src="{{ho e( asset('assets/js/functions.}}"></script>

</body>
</html>
