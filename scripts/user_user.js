// сортировка
function fetchSortedApplications(sort) {
	fetch('application-manage.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: new URLSearchParams({ sort: sort }),
	})
		.then((response) => response.json())
		.then((applications) => {
			const container = document.querySelector('#applications');
			container.innerHTML = '';

			if (applications.length === 0) {
				container.innerHTML = `
				<p 
					id="filler" 
					style="height: 20vh; font-size: 1.5rem; font-weight: bold;">
					У вас пока нет заявок 🤔
				</p>
				`;
			} else {
				applications.forEach((application) => {
					const statusClass =
						application.status === 'Отклонена'
							? 'declined'
							: application.status === 'Решена'
							? 'solved'
							: '';

					let applicationHTML = '';
					if (application.status === 'Ожидает') {
						applicationHTML += `
						<form 
							action="application-manage.php" 
							method="post" 
							class="container-outlined application"
							onsubmit="return confirm('Вы уверены, что хотите удалить эту заявку?');">
							<input type="hidden" name="application_id" value="${application.id}">
						`;
					} else {
						applicationHTML += `
						<section class="container-outlined application">
						`;
					}

					applicationHTML += `
					<div class="group">
						<p class="date text-faded">${application.date}</p>
						<p class="category colored">${application.category}</p>
					</div>
					<header>
						<h3>${application.title}</h3>
					</header>
					<p>${application.description}</p>
					<div class="group status">
						<p class="caption">Статус</p>
						<p class="${statusClass}">${application.status}</p>
					</div>
					`;

					if (application.status === 'Ожидает') {
						applicationHTML += `
							<button type="submit" name="application-delete">
								Удалить заявку
							</button>
						</form>
						`;
					} else {
						applicationHTML += `
						</section>
						`;
					}

					container.innerHTML += applicationHTML;
				});
			}
		})
		.catch((err) => console.error('Ошибка:', err));
}

// проверка пустых полей
let checkForm = (title, description, submit) => {
	title.addEventListener(`input`, function () {
		submit.disabled = this.value === ``;
	});
	description.addEventListener(`input`, function () {
		submit.disabled = this.value === ``;
	});
};

document.addEventListener('DOMContentLoaded', () => {
	// сортировка
	if (document.querySelector(`#sort`)) {
		fetchSortedApplications('В порядке добавления');
	}

	// обработка формы входа
	const loginForm = document.querySelector('#form-login');
	if (loginForm) {
		loginForm.addEventListener('submit', function (evt) {
			evt.preventDefault();

			const formData = new FormData(this);

			fetch('auth.php', {
				method: 'POST',
				body: formData,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.status === 'success') {
						window.location.href = 'user.php';
					} else {
						alert(data.message);
					}
				})
				.catch((error) => console.error('Ошибка:', error));
		});
	}

	// ограничение максимального размера загрузки файла (file) на submit
	document
		.querySelector(`#form-application-manage`)
		.addEventListener(`submit`, (evt) => {
			let fileNode = document.querySelector(`#path`);
			let file = fileNode.files[0];
			let maxSize = 10 * 1024 * 1024; // 10 MB
			let warning = document.querySelector(`#warning`);

			if (!warning) {
				warning = document.createElement(`p`);
				warning.setAttribute(`id`, `warning`);
				warning.style.color = 'red';
				warning.innerHTML = `Файл не должен быть больше 10 МБ.`;
				fileNode.insertAdjacentElement(`afterend`, warning);
			}

			if (file && file.size > maxSize) {
				evt.preventDefault();
				warning.style.display = 'block';
			} else {
				warning.style.display = 'none';
			}

			let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.bmp)$/i;
			if (file && !allowedExtensions.exec(fileNode.value)) {
				evt.preventDefault();
				warning.innerHTML = `Допустимые форматы: .jpg, .jpeg, .png, .bmp.`;
				warning.style.display = 'block';
			}

			if (
				file &&
				file.size <= maxSize &&
				allowedExtensions.exec(fileNode.value)
			) {
				warning.remove();
			}
		});

	// проверка пустых полей
	checkForm(
		document.querySelector(`#title`),
		document.querySelector(`#description`),
		document.querySelector(`#send-application`)
	);
});
