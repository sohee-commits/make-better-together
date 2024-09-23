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

document.addEventListener('DOMContentLoaded', () => {
	if (document.querySelector(`#sort`)) {
		fetchSortedApplications('В порядке добавления');
	}
});

// ограничение максимального размера загрузки файла (file) на submit
document
	.querySelector(`#form-application-manage`)
	.addEventListener(`submit`, (evt) => {
		let fileNode = document.querySelector(`#path`);
		let file = fileNode.files[0];
		let maxSize = 10 * 1024 * 1024; // 10 MB
		let warning = document.querySelector(`#warning`);

		// если еще нет ноды warning
		if (!warning) {
			warning = document.createElement(`p`);
			warning.setAttribute(`id`, `warning`);
			warning.style.color = 'red';
			warning.innerHTML = `Файл не должен быть больше 10 МБ.`;
			fileNode.insertAdjacentElement(`afterend`, warning);
		}

		// если файл выбран и не превышает 10мб
		if (file && file.size > maxSize) {
			evt.preventDefault();
			warning.style.display = 'block';
		} else {
			warning.style.display = 'none';
		}
	});

// проверка пустых полей
let checkForm = (title, description, submit) => {
	// название
	title.addEventListener(`input`, function () {
		if (this.value === ``) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});
	// описание
	description.addEventListener(`input`, function () {
		if (this.value === ``) {
			submit.disabled = true;
		} else {
			submit.disabled = false;
		}
	});
	// категория в любом случае не пустая
	// file проверяется отдельно
};

checkForm(
	document.querySelector(`#title`),
	document.querySelector(`#description`),
	document.querySelector(`#send-application`)
);
