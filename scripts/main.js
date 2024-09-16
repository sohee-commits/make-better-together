// подсвечивание навигации

const indexLink = document.querySelectorAll(`nav a[href="index.html"]`);
const userLink = document.querySelectorAll(`nav a[href="user.html"]`);

// страницы только две, мб открыта index/без названия
// поэтому идем от противоположного — user
if (window.location.href.includes(`user.html`)) {
	indexLink.forEach((link) => {
		link.classList.remove(`colored`);
	});
	userLink.forEach((link) => {
		link.classList.add(`colored`);
	});
	// а если не user (index/без названия), то подсвечиваем главная
} else {
	indexLink.forEach((link) => {
		link.classList.add(`colored`);
	});
	userLink.forEach((link) => {
		link.classList.remove(`colored`);
	});
}

// открытие навигации

const openNav = document.querySelector(`#open-nav`);
const nav = document.querySelector(`header#header-mobile ul`);

openNav.addEventListener(`click`, () => {
	nav.classList.toggle(`hidden`);
});
