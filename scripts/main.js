// подсвечивание навигации
const highlightNav = () => {
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
};

// открытие навигации
const openMobileNav = () => {
	const openNav = document.querySelector(`#open-nav`);
	const nav = document.querySelector(`header#header-mobile ul`);

	openNav.addEventListener(`click`, () => {
		nav.classList.toggle(`hidden`);
	});
};

// звуки при обновлении количества решенных заявок
const playCounterSound = () => {
	let lastCount = parseInt(document.querySelector(`#counter-solved`).innerHTML);

	setInterval(() => {
		fetch(`counter.php`)
			.then((response) => {
				if (!response.ok) {
					alert(`ошибка звука`);
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
					counter.style.transform = `scale(1.1)`;
					setTimeout(() => {
						counter.style.transform = `scale(1)`;
					}, 300);
				}

				lastCount = currentCount;
			})
			.catch((err) => {
				alert(err);
			});
	}, 5000);
};

// проверка ввода формы входа
const checkLoginForm = (login, password, submit) => {
	submit.disabled = true;

	// логин только латиница
	login.addEventListener(`input`, function () {
		this.value = this.value.replace(/[^A-Za-z]/g, ``);
		login.placeholder = `Попробуйте сменить раскладку`;
	});

	// пароль не меньше 8 символов
	password.addEventListener(`input`, function () {
		if (this.value.length < 8) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});
};

// проверка ввода формы регистрации
const checkRegisterForm = (
	login,
	password,
	passwordRepeat,
	email,
	name,
	submit
) => {
	submit.disabled = true;

	// логин только латиница
	login.addEventListener(`input`, function () {
		this.value = this.value.replace(/[^A-Za-z]/g, ``);
		login.placeholder = `Попробуйте сменить раскладку`;
	});

	// пароль не меньше 8 символов
	password.addEventListener(`input`, function () {
		if (this.value.length < 8) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});

	// проверка повтора пароля
	passwordRepeat.addEventListener(`input`, function () {
		if (password.value !== this.value) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});

	// проверка email
	email.addEventListener(`input`, function () {
		if (!this.value.includes(`@`)) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});

	// проверка фио (главное не пустое)
	name.addEventListener(`input`, function () {
		if (this.value === ``) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});
};

document.addEventListener(`DOMContentLoaded`, () => {
	highlightNav();
	openMobileNav();
	playCounterSound();
	checkLoginForm(
		document.querySelector(`#login`),
		document.querySelector(`#password`),
		document.querySelector(`button[name="button-login"]`)
	);
	checkRegisterForm(
		document.querySelector(`#login_new`),
		document.querySelector(`#password_new`),
		document.querySelector(`#password_repeat`),
		document.querySelector(`#email`),
		document.querySelector(`#name`),
		document.querySelector(`button[name="button-register"]`)
	);
});
