document.addEventListener('DOMContentLoaded', function () {
    const navButtons = document.querySelectorAll('.profile-link');

    navButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            updateActiveButton(navButtons, e.target);
        })
    });

    changeDisplay();
    updateActiveButton(navButtons);
    window.addEventListener('hashchange', function () {
        changeDisplay();
        updateActiveButton(navButtons);
    });
});

function changeDisplay() {
    const profileSections = document.querySelectorAll('.profile-section');
    const hash = window.location.hash;
    if (hash) {
        const section = document.querySelector(hash);
        if (section) {
            profileSections.forEach(function (profileSection) {
                profileSection.style.display = 'none';
            })
            section.style.display = 'block';
        }
    } else {
        document.querySelector('#posts-tab').style.display = 'block';
    }
}

function updateActiveButton(navButtons, activeButton = null) {
    navButtons.forEach(button => {
        if (button === activeButton || button.hash === window.location.hash) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}
