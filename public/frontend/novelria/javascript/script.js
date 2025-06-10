document.addEventListener('DOMContentLoaded', function () {
    const contentDiv = document.querySelector('.content');
	const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

	menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('is-active');
        menuToggle.classList.toggle('is-active');
    });
});