// подсвечивание навигации

const indexLink = document.querySelectorAll(`nav a[href="index.php"]`);
const userLink = document.querySelectorAll(`nav a[href="user.php"]`);

// страницы только две, мб открыта index/без названия
// поэтому идем от противоположного — user
if (window.location.href.includes(`user.php`)) {
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

// звуки при обновлении количества решенных заявок
let lastCount = parseInt(document.querySelector(`#counter-solved`).innerHTML);

setInterval(() => {
	fetch(`counter.php`)
		.then((response) => {
			if (!response.ok) {
				alert(`ошибка`);
			}
			return response.json();
		})
		.then((data) => {
			let currentCount = parseInt(data.count);
			document.querySelector(`#counter-solved`).innerHTML = currentCount;

			if (currentCount > lastCount) {
				let sound = new Audio(`assets/sound.mp3`);
				sound.play();

				const counter = document.querySelector(`#counter-solved`);
				counter.style.transform = 'scale(1.1)';
				setTimeout(() => {
					counter.style.transform = 'scale(1)';
				}, 300);
			}

			lastCount = currentCount;
		})
		.catch((err) => {
			alert(err);
		});
}, 5000);
