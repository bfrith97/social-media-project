<!-- Nav Search START -->
<div class="nav mt-3 mt-lg-0 flex-nowrap align-items-center px-4 px-lg-0">
    <div class="nav-item w-100">
        <form class="dropdown rounded position-relative" action="{{ route('search') }}" method="get" id="search-form">
            @csrf
            <input class="form-control ps-5 bg-light" type="search" placeholder="Search..." aria-label="Search" name="search" id="search-input">
            <button class="btn bg-transparent px-2 py-0 position-absolute top-50 start-0 translate-middle-y" type="submit">
                <i class="bi bi-search fs-5"></i>
            </button>
            <ul class="dropdown-menu w-100" id="search-results" style="max-height: 400px; overflow-y: auto; ">
                <!-- Search results will be populated here -->
            </ul>
        </form>
    </div>
</div>
<!-- Nav Search END -->
