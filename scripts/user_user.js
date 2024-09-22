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
