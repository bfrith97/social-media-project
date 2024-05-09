document.addEventListener('DOMContentLoaded', function () {
    const main = document.querySelector('main');
    let searchInput = document.querySelector('#search-input');
    let searchForm = document.querySelector('#search-form');
    const resultsContainer = document.getElementById('search-results');

    // Debounced search function
    const debouncedSearch = debounce(() => {
        const query = encodeURIComponent(searchInput.value.trim());
        if (query.length > 1) {
            const url = `${searchForm.action}?search=${query}`;
            search(url);
        } else {
            resultsContainer.innerHTML = ''; // Clear previous results
            hideDropdown(); // Hide the dropdown if not enough characters
        }
    }, 300);

    // Event listener for keyup
    searchInput.addEventListener('keyup', (e) => {
        e.preventDefault();
        debouncedSearch();
    });

    main.addEventListener('click', (e) => {
        hideDropdown();
    });

    searchInput.addEventListener('click', (e) => {
        showDropdown();
    });

    // Initialize dropdown manually
    let dropdown = new bootstrap.Dropdown(searchInput, {
        autoClose: true
    });

    function search(url) {
        fetch(url, {
            method: 'GET',
            headers: {'Accept': 'application/json'}
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                displayResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displayResults(data) {
        resultsContainer.innerHTML = ''; // Clear previous results
        if (data.length === 0) {
            resultsContainer.innerHTML = '<li class="dropdown-item">No results found</li>';
            showDropdown(); // Show the dropdown only if there are results
        } else {
            data.forEach(item => {
                let html = `
                <li class="d-flex nav-link dropdown-item">
                    <a class="btn icon-md p-0" href="/profiles/${item.id}" >
                        <img class="avatar-img rounded-2" src="http://127.0.0.1:8000/${item.picture}" alt="">
                    </a>
                        <a class="dropdown-item pt-0" href="/profiles/${item.id}">
                            ${item.name}
                            <br><small><i>${item.subtitle}</i></small>
                        </a>
                </li>
                `;
                const range = document.createRange();
                const documentFragment = range.createContextualFragment(html);
                resultsContainer.appendChild(documentFragment);
            });
            showDropdown(); // Show the dropdown only if there are results
        }
    }

    function showDropdown() {
        if (searchInput.value.trim().length > 1) {
            dropdown.show();
        }
    }

    function hideDropdown() {
        dropdown.hide();
    }

    function debounce(func, delay) {
        let debounceTimer;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
    }
});
