document.addEventListener('DOMContentLoaded', function () {
    let main = document.querySelector('main');
    let searchInput = document.querySelector('#search-users-input');
    let searchForm = document.querySelector('#new-chat-form');
    let resultsContainer = document.querySelector('#user-results');

    // Debounced search function
    const debouncedSearch = debounce(() => {
        const query = encodeURIComponent(searchInput.value.trim());
        if (query.length > 1) {
            const url = `${searchForm.action}?search=${query}`;
            search(url);
        } else {
            resultsContainer.innerHTML = ''; // Clear previous results
        }
    }, 300);

    // Event listener for keyup
    searchInput.addEventListener('keyup', (e) => {
        e.preventDefault();
        debouncedSearch();
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
                displayResults(data['users'], data['csrfToken'], data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displayResults(users, csrfToken,data) {
        resultsContainer.innerHTML = ''; // Clear previous results
        if (users.length === 0) {
            resultsContainer.innerHTML = '<li class="dropdown-item">No results found</li>';
        } else {
            users.forEach(item => {
                let html = `
                <form action="${data['create_conversation_route']}" method="post" onsubmit="submitConversation(event)">
                    <input type="hidden" name="_token" value="${csrfToken}" autocomplete="off">
                    <input type="hidden" name="user_id" value="${item.id}" autocomplete="off">
                    <li class="d-flex nav-link dropdown-item py-2">
                        <button type="submit" class="btn icon-md p-0" href="#">
                            <img class="avatar-img rounded-2" src="${item.profile_picture}" alt="">
                        </button>
                        <button type="submit" class="dropdown-item pt-0 ps-2" href="/profiles/${item.id}">
                            ${item.name}
                            <br><small><i>${item.subtitle}</i></small>
                        </button>
                    </li>
                </form>
                `;
                const range = document.createRange();
                const documentFragment = range.createContextualFragment(html);
                resultsContainer.appendChild(documentFragment);
            });
        }
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
