// подсвечивание навигации

const indexLink = document.querySelectorAll(`nav a[href="index.html"]`);
const userLink = document.querySelectorAll(`nav a[href="user.html"]`);

if (window.location.href.includes(`index.html`)) {
	// если на главной, то подсветится элемент навигации Главная страница
	indexLink.forEach((link) => {
		link.classList.add(`colored`);
	});
	// убираем класс у элемента навигации Личный кабинет
	userLink.forEach((link) => {
		link.classList.remove(`colored`);
	});
} else {
	// если ЛК, то подсветится элемент навигации Личный кабинет
	indexLink.forEach((link) => {
		link.classList.remove(`colored`);
	});
	// убираем класс у элемента навигации Главная страница
	userLink.forEach((link) => {
		link.classList.add(`colored`);
	});
}

// открытие навигации

const openNav = document.querySelector(`#open-nav`);
const nav = document.querySelector(`header#header-mobile ul`);

openNav.addEventListener(`click`, () => {
	nav.classList.toggle(`hidden`);
});
