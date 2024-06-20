@if(\Route::currentRouteName() != 'messages.index' && \Route::currentRouteName() != 'login' && \Route::currentRouteName() != 'register')
    <x-messages.chat.chat :conversations="$conversations" :user="$user"/>
@endif

<footer class="bg-mode py-3 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Footer nav START -->
                <p class="text-end mb-0">
                    <a target="_blank" href=""> About </a>
                    (TODO)
                    <a target="_blank" href="" class="ms-3"> Docs </a>
                    (TODO)
                </p>
                <!-- Footer nav START -->
            </div>
            <div class="col-md-4">
                <!-- Copyright START -->
                <p class="text-center mb-0">POWERED BY LARAVEL 11
                </p>
                <!-- Copyright END -->
            </div>
            <div class="col-md-4">
                <!-- Copyright START -->
                <p class="text-end mb-0">2024 - Made by Brandon Frith
                    <a target="_blank" href="https://www.linkedin.com/in/brandon-f-5ba635130/"> (LinkedIn) </a>
                    <a target="_blank" href="https://github.com/bfrith97"> (GitHub) </a>
                </p>
                <!-- Copyright END -->
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Vendors -->
<script src="{{ asset('assets/vendor/tiny-slider/dist/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/vendor/OverlayScrollbars-master/js/OverlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox-master/dist/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendor/plyr/plyr.js') }}"></script>
<script src="{{ asset('assets/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/vendor/zuck.js/dist/zuck.min.js') }}"></script>
<script src="{{ asset('assets/js/zuck-stories.js') }}"></script>
<script src="{{ asset('assets/js/functions.js') }}"></script>

<!-- Stacked JS -->
@stack('js')
<script src="{{ asset('js/nav/search.js') }}"></script>
<script src="{{ asset('js/nav/notifications.js') }}"></script>
@if(\Route::currentRouteName() != 'messages.index' && \Route::currentRouteName() != 'login')
<script src="{{ asset('js/messages/chat.js') }}"></script>
@endif

<!-- Theme Functions -->
<script src="{{ asset('assets/js/functions.js') }}"></script>

</body>
</html>
