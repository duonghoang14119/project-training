const dropdownToggle = document.querySelector('.dropdown-toggle');
const submenu = document.querySelector('.submenu');

dropdownToggle.addEventListener('click', function() {
    submenu.classList.toggle('show');
});

window.addEventListener('click', function(event) {
    if (!dropdownToggle.contains(event.target) && !submenu.contains(event.target)) {
        submenu.classList.remove('show');
    }
});
