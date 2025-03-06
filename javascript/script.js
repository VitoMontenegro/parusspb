/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('input, textarea').forEach((field) => {
		field.addEventListener('focus', function () {
			this.dataset.placeholder = this.placeholder; // Сохраняем текущий placeholder
			this.placeholder = ''; // Убираем его
		});

		field.addEventListener('blur', function () {
			this.placeholder = this.dataset.placeholder || ''; // Восстанавливаем
		});
	});

	const sidebar = document.getElementById('sidebar-menu');
	let lastScrollY = window.scrollY;
	if (sidebar) {
		window.addEventListener('scroll', () => {
			if (window.scrollY > lastScrollY) {
				// Скролл вниз
				sidebar.classList.remove('lg:top-[40px]');
				sidebar.classList.add('lg:top-[-400px]');
			} else {
				// Скролл вверх
				sidebar.classList.remove('lg:top-[-400px]');
				sidebar.classList.add('lg:top-[40px]');
			}
			lastScrollY = window.scrollY;
		});
	}
	// Получаем элементы мобильного меню
	const menuToggle = document.getElementById('menu-toggle');
	const mobileMenu = document.getElementById('mobile-menu');

	if (menuToggle && mobileMenu) {
		menuToggle.addEventListener('click', (event) => {
			event.stopPropagation(); // предотвращаем всплытие события, чтобы не закрывать меню сразу после его открытия
			// Переключаем меню
			if (menuToggle.classList.contains('is-active')) {
				mobileMenu.classList.remove('-translate-x-[1700px]');
				mobileMenu.classList.add('translate-x-0');
				document.body.style.overflow = 'hidden'; // Отключаем прокрутку
			} else {
				mobileMenu.classList.remove('translate-x-0');
				mobileMenu.classList.add('-translate-x-[1700px]');
				document.body.style.overflow = ''; // Включаем прокрутку обратно
			}
			// Переключаем класс is-active у кнопки
			menuToggle.classList.toggle('is-active');
		});

		document.addEventListener('click', (event) => {
			// Проверяем, был ли клик вне меню и кнопки
			if (
				!mobileMenu.contains(event.target) &&
				!menuToggle.contains(event.target)
			) {
				mobileMenu.classList.remove('translate-x-0');
				mobileMenu.classList.add('-translate-x-[1700px]');
				menuToggle.classList.add('is-active');
				document.body.style.overflow = ''; // Включаем прокрутку обратно
			}
		});
	}

	// Получаем элементы сайдбар
	const sidebarToggles = document.querySelectorAll('.sidebar-toggle');
	const sidebarMenu = document.getElementById('sidebar-menu');

	if (sidebarToggles.length && sidebarMenu) {
		sidebarToggles.forEach((sidebarToggle) => {
			sidebarToggle.addEventListener('click', (event) => {
				event.stopPropagation(); // предотвращаем всплытие события, чтобы не закрывать меню сразу после его открытия

				if (sidebarToggle.classList.contains('is-active')) {
					sidebarMenu.classList.remove('-translate-x-[1700px]');
					sidebarMenu.classList.add('translate-x-0');
				} else {
					sidebarMenu.classList.remove('translate-x-0');
					sidebarMenu.classList.add('-translate-x-[1700px]');
				}
				// Переключаем класс is-active у кнопки
				sidebarToggle.classList.toggle('is-active');
			});

			document.querySelectorAll('.close-filter-btn').forEach((button) => {
				button.addEventListener('click', () => {
					sidebarToggle.classList.toggle('is-active');
					sidebarMenu.classList.remove('translate-x-0');
					sidebarMenu.classList.add('-translate-x-[1700px]');
				});
			});

			document.addEventListener('click', (event) => {
				// Проверяем, был ли клик вне меню и кнопки
				if (
					!sidebarMenu.contains(event.target) &&
					!sidebarToggle.contains(event.target)
				) {
					sidebarMenu.classList.remove('translate-x-0');
					sidebarMenu.classList.add('-translate-x-[1700px]');
					sidebarToggle.classList.add('is-active');
				}
			});
		});
	}

	const swiper_rev = new Swiper('.swiper_rev', {
		slidesPerView: 1.2, // Показывает два с половиной слайда
		spaceBetween: 20, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.rev-button-next',
			prevEl: '.rev-button-prev',
		},
		breakpoints: {
			490: {
				slidesPerView: 3, // Показывает два с половиной слайда
				spaceBetween: 32,
			},
		},
	});
	// Обновление кнопок при инициализации
	swiper_rev.on('init', () => {
		document
			.querySelector('.rev-button-prev')
			.classList.remove('swiper-button-disabled');
		document
			.querySelector('.rev-button-next')
			.classList.remove('swiper-button-disabled');
	});
	swiper_rev.init();

	const swiper_similar = new Swiper('.swiper_similar', {
		slidesPerView: 1, // Показывает два с половиной слайда
		spaceBetween: 20, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.similar-button-next',
			prevEl: '.similar-button-prev',
		},
		breakpoints: {
			490: {
				slidesPerView: 3, // Показывает два с половиной слайда
				spaceBetween: 32,
			},
		},
	});
	// Обновление кнопок при инициализации
	swiper_rev.on('init', () => {
		document
			.querySelector('.similar-button-prev')
			.classList.remove('swiper-button-disabled');
		document
			.querySelector('.similar-button-next')
			.classList.remove('swiper-button-disabled');
	});
	swiper_rev.init();

	const swiper_gids = new Swiper('.swiper_gids', {
		slidesPerView: 1.2, // Показывает два с половиной слайда
		spaceBetween: 20, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.gid-button-next',
			prevEl: '.gid-button-prev',
		},
		breakpoints: {
			490: {
				slidesPerView: 3.5, // Показывает два с половиной слайда
				spaceBetween: 32,
			},
		},
	});
	// Обновление кнопок при инициализации
	swiper_gids.on('init', () => {
		document
			.querySelector('.gid-button-prev')
			.classList.remove('swiper-button-disabled');
		document
			.querySelector('.gid-button-next')
			.classList.remove('swiper-button-disabled');
	});

	swiper_gids.init();

	const swiper = new Swiper('.swiper_custom', {
		slidesPerView: 1.2, // Показывает два с половиной слайда
		spaceBetween: 20, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination', // Селектор для контейнера точек
			clickable: true, // Позволяет кликать по точкам для перехода
		},
		breakpoints: {
			490: {
				slidesPerView: 3, // Показывает два с половиной слайда
				spaceBetween: 32,
			},
		},
	});

	const swiper_four = new Swiper('.swiper_four', {
		slidesPerView: 1.2, // Показывает два с половиной слайда
		spaceBetween: 24, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination', // Селектор для контейнера точек
			clickable: true, // Позволяет кликать по точкам для перехода
		},
		breakpoints: {
			490: {
				slidesPerView: 3, // Показывает два с половиной слайда
				spaceBetween: 24,
			},
			1100: {
				slidesPerView: 4, // Показывает два с половиной слайда
				spaceBetween: 24,
			},
		},
	});

	const swiper_five = new Swiper('.swiper_five', {
		slidesPerView: 1.2, // Показывает два с половиной слайда
		spaceBetween: 24, // Отступы между слайдами
		centeredSlides: false, // Убирает центровку активного слайда
		loop: true, // Зацикливает слайды
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		pagination: {
			el: '.swiper-pagination', // Селектор для контейнера точек
			clickable: true, // Позволяет кликать по точкам для перехода
		},
		breakpoints: {
			490: {
				slidesPerView: 3, // Показывает два с половиной слайда
				spaceBetween: 24,
			},
			1100: {
				slidesPerView: 5, // Показывает два с половиной слайда
				spaceBetween: 24,
			},
		},
	});

	const swiperTour = document.querySelectorAll('.swiper_tour');
	if (swiperTour.length) {
		const swiper2 = new Swiper('.mySwiper2', {
			spaceBetween: 8,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});

		const swiperSlides = document.querySelectorAll('.fancy-video img');

		// Для всех слайдов в Swiper добавляем ссылку с атрибутами для Fancybox
		swiperSlides.forEach((slide) => {
			const mediaSrc = slide.getAttribute('src');
			const mediaAlt = slide.getAttribute('alt');
			const videoId = slide.getAttribute('data-video-id');
			const videoType = slide.getAttribute('data-video-type');

			// Если это изображение
			if (!videoId) {
				slide.setAttribute('data-src', mediaSrc); // Ссылка на изображение
				slide.setAttribute('data-caption', mediaAlt); // Подпись изображения
			} else {
				// Если это видео, создаем ссылку на видео
				let videoUrl = '';
				if (videoType === 'youtube') {
					videoUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
				} else if (videoType === 'rutube') {
					videoUrl = `https://rutube.ru/play/embed/${videoId}?autoplay=1`;
				} else if (videoType === 'dzen') {
					videoUrl = videoId;
				}

				slide.setAttribute('data-fancybox', 'gallery'); // Группа галереи
				slide.setAttribute('data-src', videoUrl); // Ссылка на видео
				slide.setAttribute('data-caption', mediaAlt); // Подпись видео
			}
		});

		Fancybox.bind('[data-fancybox="gallery"]', {
			infinite: true,
			groupAll: true,
			caption: function (fancybox, carousel, slide) {
				return slide.alt;
			},
			// Можно добавить другие опции Fancybox
		});
	}

	const swiperBlock = document.querySelectorAll('.swiper_block');
	if (swiperBlock) {
		const newSwiperBlock = new Swiper('.swiperBlock', {
			slidesPerView: 2.2,
			spaceBetween: 11,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				490: {
					slidesPerView: 2.2,
					spaceBetween: 11,
				},
				790: {
					slidesPerView: 3,
					spaceBetween: 24,
				},
				1023: {
					slidesPerView: 5,
					spaceBetween: 24,
				},
			},
		});
	}

	const swiper_small = document.querySelectorAll('.swiper_small');
	if (swiper_small) {
		const swiperSmall = new Swiper('.swiper_small', {
			slidesPerView: 1.5, // Показывает два с половиной слайда
			spaceBetween: 24, // Отступы между слайдами
			centeredSlides: false, // Убирает центровку активного слайда
			loop: true, // Зацикливает слайды
			navigation: {
				nextEl: '.rev-button-next',
				prevEl: '.rev-button-prev',
			},
			breakpoints: {
				490: {
					slidesPerView: 4, // Показывает два с половиной слайда
					spaceBetween: 24,
				},
			},
		});
	}

	// Сохраняем экземпляр Flatpickr

/*	let selectedDatesRange = null;
	const calendarInstance = flatpickr('#calendar', {
		inline: true,
		mode: 'range',
		minDate: 'today',
		dateFormat: 'Y-m-d',
		locale: 'ru', // Указываем код языка
		onChange: function (selectedDates, dateStr) {
			selectedDatesRange = {
				dates: selectedDates,
				range: dateStr,
			};
		},
	});*/
	let selectedDatesRange = null;

	const calendarInstance = flatpickr('#calendar', {
		inline: true,
		mode: 'range',
		minDate: 'today',
		dateFormat: 'Y-m-d',
		locale: 'ru',
		onChange: function (selectedDates, dateStr, instance) {
			selectedDatesRange = {
				dates: selectedDates,
				range: dateStr,
			};

			// Очищаем старый подтвержденный диапазон при новом клике
			document.querySelectorAll(".flatpickr-day.confirmed-range").forEach(el => {
				el.classList.remove("confirmed-range");
			});

			if (selectedDates.length === 2) {
				setTimeout(() => { // Ждём отрисовки flatpickr
					document.querySelectorAll(".flatpickr-day.inRange").forEach(el => {
						el.classList.add("confirmed-range");
					});
				}, 10);
			}
		}
	});

	const okBtn = document.getElementById('okBtn');
	const cancelBtn = document.getElementById('cancelBtn');
	if (okBtn && cancelBtn) {
		// Кнопка "Ок"
		okBtn.addEventListener('click', function () {
			if (selectedDatesRange && selectedDatesRange.dates.length) {
				document.querySelector('input[name="dateForm"]').value =
					selectedDatesRange.range;
				document
					.querySelector('input[name="dateForm"]')
					.dispatchEvent(new Event('change', { bubbles: true }));
			} else {
				alert('Пожалуйста, выберите диапазон дат!');
			}
		});

		// Кнопка "Отмена"
		cancelBtn.addEventListener('click', function () {
			selectedDatesRange = null; // Сбрасываем выбранные даты
			calendarInstance.clear(); // Используем метод .clear() на экземпляре Flatpickr
			clearForm();
			removeGetParams();
			document.querySelector('input[name="dateForm"]').value = null;
			document
				.querySelector('input[name="dateForm"]')
				.dispatchEvent(new Event('change', { bubbles: true }));

			document
				.querySelectorAll('#cat_sidebar .flex.items-center a')
				.forEach((link) => {
					const url =
						window.location.origin + window.location.pathname;
					link.href = url.toString();
				});
		});
	}

	function startCalendars() {
		document.querySelectorAll('.calendar-wrapper').forEach((wrapper) => {
			const calendarElement = wrapper.querySelector('.calendar');
			const selectedDatesAttr = wrapper.getAttribute('data-dates'); // Получаем даты из data-attr

			// Парсим даты, если они есть
			const selectedDates = selectedDatesAttr
				? JSON.parse(selectedDatesAttr)
				: [];

			// Инициализация Flatpickr с установленными датами
			const calendarInstance = flatpickr(calendarElement, {
				inline: true,
				minDate: 'today',
				dateFormat: 'Y-m-d',
				locale: 'ru', // Указываем код языка
				defaultDate: selectedDates, // Устанавливаем выбранные даты
				disable: [
					function (date) {
						// Преобразуем текущую дату и сравниваем с каждой датой из selectedDates
						const currentDate = date.toISOString().split('T')[0];
						const isDefaultDate =
							selectedDates.includes(currentDate);

						// Блокируем все даты, не входящие в selectedDates и не больше/равные minDate
						return !isDefaultDate && date < new Date();
					},
				],
				onReady: function () {
					// Отключаем hover-эффект на недопустимых датах
					const calendarDays =
						calendarElement.querySelectorAll('.flatpickr-day');
					calendarDays.forEach((day) => {
						const date = day.getAttribute('aria-label');
						if (
							!selectedDates.includes(date) &&
							day.classList.contains('flatpickr-disabled')
						) {
							day.classList.remove('selected');
						}
					});
				},
				onChange: function () {
					// Сбрасываем выбор на defaultDate
					calendarInstance.setDate(selectedDates, false);
				},
			});
		});
	}
	startCalendars();

	document.addEventListener('click', function (event) {
		const cancel = event.target;

		if (cancel.id === 'cancelBtnFilter') {
			selectedDatesRange = null; // Сбрасываем выбранные даты
			calendarInstance.clear(); // Используем метод .clear() на экземпляре Flatpickr
			clearForm();
			removeGetParams();
			document.querySelector('input[name="dateForm"]').value = null;
			document
				.querySelector('input[name="dateForm"]')
				.dispatchEvent(new Event('change', { bubbles: true }));

			document
				.querySelectorAll('#cat_sidebar .flex.items-center a')
				.forEach((link) => {
					const url =
						window.location.origin + window.location.pathname;
					link.href = url.toString();
				});
		}
	});

	// Функция для открытия/закрытия dropdown
	document.addEventListener('click', function (event) {
		const dropdownButtons = document.querySelectorAll('.dropdown-button');
		const dropdownMenus = document.querySelectorAll('.dropdown-menu');

		// Проверяем, кликнули ли по кнопке dropdown
		const button = event.target.closest('.dropdown-button');
		if (button) {
			const index = Array.from(dropdownButtons).indexOf(button);
			const menu = dropdownMenus[index];

			if (!menu) return;

			const isExpanded = menu.classList.contains('hidden');

			// Закрываем все меню
			dropdownMenus.forEach((otherMenu, otherIndex) => {
				if (otherIndex !== index) {
					otherMenu.classList.add('hidden');
					dropdownButtons[otherIndex].setAttribute(
						'aria-expanded',
						'false'
					);
				}
			});

			// Переключаем текущее меню
			if (isExpanded) {
				menu.classList.remove('hidden');
				button.setAttribute('aria-expanded', 'true');
			} else {
				menu.classList.add('hidden');
				button.setAttribute('aria-expanded', 'false');
			}
			return;
		}

		// Проверяем, кликнули ли по элементу внутри меню для закрытия
		const menuItem = event.target.closest('.dropdown-menu .item');
		if (menuItem) {
			const menu = menuItem.closest('.dropdown-menu');
			const button = document.querySelector(
				`.dropdown-button[aria-expanded="true"]`
			);
			if (menu && button) {
				menu.classList.add('hidden');
				button.setAttribute('aria-expanded', 'false');
			}
			return;
		}

		// Проверяем, кликнули ли по кнопке закрытия внутри меню
		const closeButton = event.target.closest('.dropdown-menu .close-menu');
		if (closeButton) {
			const menu = closeButton.closest('.dropdown-menu');
			const button = document.querySelector(
				`.dropdown-button[aria-expanded="true"]`
			);
			if (menu && button) {
				menu.classList.add('hidden');
				button.setAttribute('aria-expanded', 'false');
			}
			return;
		}

		// Закрываем меню, если клик произошел вне него
		dropdownMenus.forEach((menu, index) => {
			if (
				!menu.contains(event.target) &&
				!dropdownButtons[index].contains(event.target)
			) {
				menu.classList.add('hidden');
				dropdownButtons[index].setAttribute('aria-expanded', 'false');
			}
		});
	});

	//filter excursion
	const categoryIdElem = document.getElementById('category_id');
	if (categoryIdElem) {
		const categoryId = document.getElementById('category_id').value;
		document
			.getElementById('filter-form')
			.addEventListener('change', function () {
				loadPosts();
			});
		document
			.getElementById('sort_form')
			.addEventListener('change', function () {
				loadPosts();
			});
		function loadPosts() {
			// Собираем массив значений выбранных чекбоксов
			const getCheckedValues = (name) => {
				return Array.from(
					document.querySelectorAll(
						`#filter-form input[name="${name}"]:checked, #sort_form input[name="${name}"]:checked`
					)
				).map((input) => input.value);
			};
			const duration = getCheckedValues('duration');
			const price = getCheckedValues('price');
			const postsPerPage = -1;
			//const grade = getCheckedValues('gradeAge');
			const grade_sort = getCheckedValues('grade_sort');
			const dateForm =
				document.querySelector('input[name="dateForm"]').value ?? null;

			const params = new URLSearchParams({
				//grade: JSON.stringify(grade),
				grade_sort: JSON.stringify(grade_sort),
				price: JSON.stringify(price),
				duration: JSON.stringify(duration),
				dateForm: dateForm,
				posts_per_page: postsPerPage,
				category_id: categoryId,
			});

			document.querySelectorAll('#cat_sidebar .flex.items-center a')
				.forEach((link) => {
					const url = new URL(link.href);
					if (dateForm) url.searchParams.set('dateForm', dateForm);

					if (price)
						url.searchParams.set('price', JSON.stringify(price));
					if (duration)
						url.searchParams.set(
							'duration',
							JSON.stringify(duration)
						);
					link.href = url.toString();
				});

			fetch('/wp-json/my_namespace/v1/filter-posts/?' + params.toString())
				.then((response) => {
					if (!response.ok) {
						throw new Error('Failed to fetch the template.'); // Проверяем, что статус ответа 200–299
					}
					return response.json(); // Парсим JSON-ответ
				})
				.then((data) => {
					document.getElementById('tours').innerHTML = data.data.html;
					document
						.getElementById('card_link')
						.scrollIntoView({ block: 'start', behavior: 'smooth' });
					startCalendars();
					//adjustCardLayout();
					adjustWishBtn();
					//sortExcursion();

					const sidebarToggles =
						document.querySelectorAll('.sidebar-toggle');
					const sidebarMenu = document.getElementById('sidebar-menu');
					if (sidebarToggles.length && sidebarMenu) {
						sidebarToggles.forEach((sidebarToggle) => {
							sidebarToggle.classList.toggle('is-active');
						});
						sidebarMenu.classList.remove('translate-x-0');
						sidebarMenu.classList.add('-translate-x-[1700px]');
					}
				})
				.catch((error) => console.error('Error loading posts:', error));
		}
	}

	function clearForm() {
		// Получаем форму
		const form = document.getElementById('filter-form');

		// Перебираем элементы формы
		Array.from(form.elements).forEach((element) => {
			switch (element.type) {
				case 'text':
				case 'textarea':
				case 'password':
				case 'email':
				case 'url':
				case 'number':
				case 'search':
				case 'tel':
				case 'hidden':
					element.value = ''; // Очистка текстовых полей
					break;
				case 'checkbox':
				case 'radio':
					element.checked = false; // Сброс чекбоксов и радио-кнопок
					break;
				case 'select-one':
				case 'select-multiple':
					element.selectedIndex = -1; // Сброс селектов
					break;
				default:
					break;
			}
		});
	}
	function removeGetParams() {
		// Получаем текущий URL без параметров
		const url = window.location.origin + window.location.pathname;

		// Обновляем URL в адресной строке без перезагрузки страницы
		window.history.replaceState({}, document.title, url);
	}
	function isValidPhone(phone) {
		if (!phone.trim()) {
			return false; // Возвращаем false, если строка пустая или состоит только из пробелов
		}
		const phoneRegex =
			/^(\+7|8)?[\s-]?(\(?\d{3}\)?)?[\s-]?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/;
		return phoneRegex.test(phone.trim());
	}


	//форма отзывов
	const formContainer = document.querySelector('.reviews_form');
	if (formContainer) {
		//Работа с файлами
		const inputField = document.getElementById('inputField');

		// Функция для показа всех элементов в списке
		function showAllSuggestions(inputField, suggestionsBox) {
			const dataItems = Array.from(
				suggestionsBox.querySelectorAll('.data-item')
			);
			dataItems.forEach((item) => {
				item.style.display = 'block';
			});
			suggestionsBox.classList.remove('hidden');
		}

		// Функция для фильтрации списка подсказок
		function showSuggestions(inputField, suggestionsBox) {
			const query = inputField.value.toLowerCase();
			const dataItems = Array.from(
				suggestionsBox.querySelectorAll('.data-item')
			);

			if (query === '') {
				suggestionsBox.classList.add('hidden');
				return;
			}

			let hasMatches = false;

			dataItems.forEach((item) => {
				if (item.textContent.toLowerCase().includes(query)) {
					item.style.display = 'block';
					hasMatches = true;
				} else {
					item.style.display = 'none';
				}
			});

			if (!hasMatches) {
				suggestionsBox.classList.add('hidden');
			} else {
				suggestionsBox.classList.remove('hidden');
			}
		}

		// Закрыть все списки
		function closeAllSuggestions() {
			document.querySelectorAll('.reviews_form placeholder ul').forEach((suggestionsBox) => {
				suggestionsBox.classList.add('hidden');
			});
		}

		// Инициализация логики для каждого поля и списка
		/*document.querySelectorAll('.list-input input[name]').forEach((inputField) => {
			const suggestionsBox = inputField.nextElementSibling; // Предполагаем, что ul идет сразу после input

			if (!suggestionsBox) return;

			inputField.addEventListener('focus', () => {
				closeAllSuggestions(); // Закрываем другие списки
				showAllSuggestions(inputField, suggestionsBox);
			});

			inputField.addEventListener('input', () =>
				showSuggestions(inputField, suggestionsBox)
			);

			inputField.addEventListener('blur', () => {
				setTimeout(() => {
					suggestionsBox.classList.add('hidden')
				}, 200);
			});

			suggestionsBox.querySelectorAll('.data-item').forEach((item) => {
				item.addEventListener('click', () => {
					inputField.value = item.textContent;

					if (inputField.getAttribute('id') === 'inputField1') {
						document.querySelector('input[name="excurs"]').value = item.getAttribute('data-name');
					}

					suggestionsBox.classList.add('hidden');

					// Убираем фокус с input
					inputField.blur();
					document.body.focus(); // Переводим фокус на body

					// Ждём завершения скрытия списка, затем возвращаем фокус
					setTimeout(() => {
						inputField.focus();
						inputField.setSelectionRange(inputField.value.length, inputField.value.length); // Ставим курсор в конец
					}, 250); // Чуть больше задержки скрытия списка
				});
			});
		});*/

		document.querySelectorAll(".list-input input[name]").forEach((inputField) => {
			const suggestionsBox = inputField.nextElementSibling; // ul идет сразу после input

			if (!suggestionsBox) return;

			// Показать список
			const showSuggestions = () => {
				suggestionsBox.classList.remove("hidden");
			};

			// Скрыть список
			const hideSuggestions = () => {
				suggestionsBox.classList.add("hidden");
			};

			// Открытие списка при фокусе на input
			inputField.addEventListener("focus", showSuggestions);

			// При вводе текста — фильтрация и обновление видимости
			inputField.addEventListener("input", () => {
				const searchValue = inputField.value.toLowerCase();
				suggestionsBox.querySelectorAll(".data-item").forEach((item) => {
					const itemText = item.textContent.toLowerCase();
					item.style.display = itemText.includes(searchValue) ? "block" : "none";
				});
				showSuggestions(); // Обновление видимости
			});

			// Обработчик клика по элементу списка
			suggestionsBox.addEventListener("mousedown", (event) => {
				const item = event.target.closest(".data-item");
				if (!item) return;

				inputField.value = item.textContent;

				// Установка значения в скрытое поле

				if (item.classList.contains('suggestions')) {
					document.querySelector('input[name="excurs"]').value = item.getAttribute("data-name");
				}


				hideSuggestions(); // Скрытие списка
			});

			// Закрытие списка при клике вне поля ввода или списка
			document.addEventListener("click", (event) => {
				if (!inputField.contains(event.target) && !suggestionsBox.contains(event.target)) {
					hideSuggestions(); // Скрываем список
				}
			});
		});





		// Закрытие списка при клике вне поля ввода и списка
		/*document.addEventListener('mousedown', (event) => {
			const isInput = event.target.tagName === 'INPUT';
			const isDataItem = event.target.classList.contains('data-item');
			if (!isInput && !isDataItem) {
				closeAllSuggestions();
			}
		});*/

		const photoInput = document.getElementById('photo-input');
		const previewContainer = document.getElementById('preview-container');
		let selectedFiles = [];

		photoInput.addEventListener('change', (event) => {
			const files = Array.from(event.target.files || []);
			files.forEach((file) => {
				if (!file.type.startsWith('image/')) return;

				const reader = new FileReader();
				reader.onload = (e) => {
					const previewElement = document.createElement('div');
					previewElement.classList.add('preview');

					const img = document.createElement('img');
					img.src = e.target?.result;

					const removeButton = document.createElement('button');
					removeButton.innerText = '×';
					removeButton.onclick = () => {
						const index = selectedFiles.indexOf(file);
						if (index > -1) {
							selectedFiles.splice(index, 1);
						}
						previewContainer.removeChild(previewElement);
					};

					previewElement.appendChild(img);
					previewElement.appendChild(removeButton);
					previewContainer.appendChild(previewElement);
				};
				reader.readAsDataURL(file);
				selectedFiles.push(file);
			});

			// Clear the input to allow re-selection of the same files if needed
			photoInput.value = '';
		});

		formContainer.addEventListener('submit', function (e) {
			e.preventDefault();

			let button = this.querySelector('.send-btn');
			let text = button.querySelector('.btn-text');
			let loader = button.querySelector('.loader');


			const thisForm = e.target;
			const name = thisForm.querySelector('[name=name]').value;
			const formData = new FormData(thisForm);

			// Добавляем файлы из filestoupload
			selectedFiles.forEach((file, index) => {
				formData.append(`file[${index}]`, file);
			});
			const nameField = document.querySelector('.name_field input');

			if (!name) {
				nameField.classList.add('alert');
				window.scrollTo({
					top: document.querySelector('.reviews_form').offsetTop - 50,
					behavior: 'smooth',
				});
				return false;
			} else {
				nameField.classList.remove('alert');
				// Показываем прелоадер
				button.disabled = true;
				text.classList.add('hidden');
				loader.classList.remove('hidden');
			}

			//document.querySelector('.page-loader').style.display = 'block';

			//document.querySelector('.page-loader').style.display = 'block';

			setTimeout(()=> {
				const popup = document.querySelector(
					'.popup[data-popup="popup-success-rev"]'
				);
				if (popup) {
					popup.classList.remove('hidden');
				}
				// Восстанавливаем кнопку
				button.disabled = false;
				text.classList.remove('hidden');
				loader.classList.add('hidden');
			},2500);

			fetch('/wp-json/custom/v1/reviews-form', {
				method: 'POST',
				headers: {
					// Убедитесь, что REST API доступен без авторизации или передайте токен авторизации.
					//'X-WP-Nonce': wpApiSettings.nonce // Если требуется авторизация
				},
				body: formData,
			}).then((response) => {
					if (!response.ok) {
						return response.json().then((err) => {
							throw new Error(
								err.message || 'Ошибка при отправке формы'
							);
						});
					}
					return response.json();
				}).then((data) => {
				console.log('Ответ сервера:', data);
			}).catch((error) => {
				console.error('Ошибка:', error);
				//alert(error.message || 'Что-то пошло не так');
			}).finally(() => {
				thisForm.reset();

				// Очистка массива загруженных файлов
				selectedFiles.length = 0;

				// Очистка контейнера превью
				previewContainer.innerHTML = '';
				//document.querySelector('.page-loader').style.display = 'none';
			});
		});
	}

	// Отправка формы
	document.querySelectorAll('.send-letter').forEach((form) => {
		form.addEventListener('submit', function (e) {
			e.preventDefault();

			const thisForm = e.target;
			const name = thisForm.getAttribute('data-api');
			const formData = new FormData(thisForm);
			const phoneField = thisForm.querySelector('input[name="tel"]');

			if (phoneField) {
				// Если поле существует
				const phone = formData.get('tel');

				if (!isValidPhone(phone)) {
					// Проверяем, если значение есть и оно некорректное
					phoneField.classList.add('border', 'border-[#FF7A45]');
					return false;
				} else if (isValidPhone(phone)) {
					// Если поле пустое или значение валидное
					phoneField.classList.remove('border', 'border-[#FF7A45]');
				}
			}

			if (name) {
				fetch(`/wp-json/custom/v1/${name}`, {
					method: 'POST',
					headers: {
						// Убедитесь, что REST API доступен без авторизации или передайте токен авторизации.
						//'X-WP-Nonce': wpApiSettings.nonce // Если требуется авторизация
					},
					body: formData,
				})
					.then((response) => {
						if (!response.ok) {
							return response.json().then((err) => {
								throw new Error(
									err.message || 'Ошибка при отправке формы'
								);
							});
						}
						return response.json();
					})
					.then((data) => {
						if (!data.success) {
							throw new Error(
								data.message || 'Ошибка при отправке формы'
							);
						}
						thisForm.reset();
						closeModal();
						const popup = document.querySelector(
							".popup[data-popup='popup-success']"
						);
						popup.classList.remove('hidden');
						return true;
					})
					.catch((error) => {
						console.error('Ошибка:', error);
						alert(error.message || 'Что-то пошло не так');
					})
					.finally(() => {
						//document.querySelector('.page-loader').style.display = 'none';
					});
			}
		});
	});

	//popups
	document.querySelectorAll('[data-open]').forEach((button) => {
		// Открываем popup по data-open
		button.addEventListener('click', function () {
			const popupName = button.getAttribute('data-open');
			const popup = document.querySelector(
				`.popup[data-popup="${popupName}"]`
			);
			if (popup) {
				popup.classList.remove('hidden');
			}
		});
	});

	function openModal(queryElement) {
		queryElement.classList.remove('hidden');
	}
	function closeModal() {
		document.querySelectorAll('.popup-close').forEach((closeButton) => {
			const popup = closeButton.closest('.popup');
			if (popup) {
				popup.classList.add('hidden');
			}
		});
	}

	document.querySelectorAll('.popup-close').forEach((closeButton) => {
		// Закрываем все popups по клику на кнопку close
		closeButton.addEventListener('click', function () {
			const popup = closeButton.closest('.popup');
			if (popup) {
				popup.classList.add('hidden');
			}
		});
	});

	// Закрытие popup по клику вне его
	document.querySelectorAll('.popup').forEach((popup) => {
		popup.addEventListener('click', function (e) {
			if (e.target === popup) {
				popup.classList.add('hidden');
				const popupContainer = popup.querySelector(
					'.popup-media-container'
				);
				if (popupContainer) {
					popupContainer.innerHTML = '';
				}
			}
		});
	});

	document.querySelectorAll('.togler').forEach((togler) => {
		togler.textContent = 'Читать весь отзыв'; // Устанавливаем текст по умолчанию

		togler.addEventListener('click', () => {
			// Переключаем текст в переключателе
			togler.textContent =
				togler.textContent === 'Читать весь отзыв'
					? 'Свернуть отзыв'
					: 'Читать весь отзыв';

			// Находим сестринский элемент и переключаем его класс
			const sibling = togler
				.closest('.text_toggle')
				.querySelector('.rev-text');
			if (sibling) {
				sibling.classList.toggle('long-rev');
				sibling.classList.toggle('short-rev');
			}
		});
	});

	//wishlist
	function adjustWishBtn() {
		const devContainer = document.getElementById('response');

		if (!devContainer) return; // Если контейнера нет, выходим

		const wishButtons = devContainer.querySelectorAll('.wish-btn');
		updateWishBtns(wishButtons);

		if (devContainer.dataset.initialized) return;

		devContainer.dataset.initialized = true;
		devContainer.addEventListener('click', (event) => {
			const button = event.target.closest('.wish-btn');
			if (!button) return; // Если клик не по wish-btn, выходим
			handleWishButtonClick(button);
		});

		function updateWishBtns(buttons) {
			let currentProducts = getCookie('product');
			try {
				currentProducts = currentProducts
					? JSON.parse(currentProducts)
					: [];
			} catch (e) {
				console.error('Error parsing cookies:', e);
				currentProducts = []; // Сбрасываем в пустой массив при ошибке
			}

			buttons.forEach((button) => {
				const productId = button.getAttribute('data-wp-id');
				// Добавляем класс active на кнопки, которые соответствуют продуктам в куки
				if (currentProducts.includes(productId)) {
					button.classList.add('active');
				}
			});
		}

		function handleWishButtonClick(button) {
			let currentProducts = getCookie('product');
			try {
				currentProducts = currentProducts
					? JSON.parse(currentProducts)
					: [];
			} catch (e) {
				console.error('Error parsing cookies:', e);
				currentProducts = [];
			}

			const productId = button.getAttribute('data-wp-id');

			// Обновляем куки и класс active
			if (currentProducts.includes(productId)) {
				// Если продукт уже в куки, удаляем его
				currentProducts = currentProducts.filter(
					(id) => id !== productId
				);
				button.classList.remove('active');
			} else {
				// Если продукта нет в куки, добавляем его
				currentProducts.push(productId);
				button.classList.add('active');
			}

			// Сохраняем обновленные куки
			setCookie('product', JSON.stringify(currentProducts), 7);
			updateProductCount(
				'product',
				'#product-count span',
				'#product-count div'
			);
		}
	}
	adjustWishBtn();

	// Функция для обновления количества продуктов, используя куку
	function updateProductCount(cookieName, elementSelector, elementDiv) {
		// Получаем значение куки по имени
		let productCookie = getCookie(cookieName);

		// Если куки существует, парсим строку и подсчитываем количество элементов
		if (productCookie) {
			try {
				let productArray = JSON.parse(productCookie); // Парсим строку как JSON
				if (Array.isArray(productArray)) {
					// Обновляем текст в указанном элементе

					document.querySelector(elementSelector).textContent =
						productArray.length;
					if (productArray.length < 1) {
						document.querySelector(elementDiv).style.visibility =
							'hidden';
					} else {
						document.querySelector(elementDiv).style.visibility =
							'visible';
					}
				}
			} catch (e) {
				console.error(
					"Ошибка при парсинге куки '" + cookieName + "':",
					e
				);
			}
		} else {
			// Если куки нет, показываем 0
			document.querySelector(elementSelector).textContent = 0;
		}
	}
	// Пример вызова функции для обновления счетчика продуктов
	updateProductCount('product', '#product-count span', '#product-count div');


	// Функция получения куки
	function getCookie(name) {
		const cookieArr = document.cookie.split(';');
		for (let i = 0; i < cookieArr.length; i++) {
			let cookie = cookieArr[i].trim();
			if (cookie.startsWith(name + '=')) {
				return cookie.substring(name.length + 1);
			}
		}
		return null;
	}

	// Функция установки куки
	function setCookie(name, value, days) {
		const date = new Date();
		date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
		const expires = 'expires=' + date.toUTCString();
		document.cookie = name + '=' + value + ';' + expires + ';path=/';
	}

	//Форма отзыва

	// Удаление файлов
	document.body.addEventListener('click', function (event) {
		if (event.target.classList.contains('delete')) {
			const index = Array.from(
				document.querySelectorAll('.delete')
			).indexOf(event.target);
			console.log('Удаляем файл:', index);

			filestoupload.splice(index, 1); // Удаляем из массива
			event.target.parentElement.remove(); // Удаляем из DOM

			console.log('Files to upload:', filestoupload.length);
		}
	});

	window.addEventListener('scroll', function () {
		if (window.innerWidth >= 1024) return;

		const cardLink = document.getElementById('card_link');
		const stickyElement = document.getElementById('sticky-element');

		if (!cardLink || !stickyElement) return;
		const cardLinkRect = cardLink.getBoundingClientRect();

		if (cardLinkRect.top <= 0 && cardLinkRect.bottom >= 1000) {
			stickyElement.classList.add('fixed');
			stickyElement.classList.remove('hidden');
		} else {
			stickyElement.classList.remove('fixed');
			stickyElement.classList.add('hidden');
		}
	});

	//интересные мета
	const items = document.querySelectorAll('.int_mesta .item');
	const showMoreBtn = document.querySelector('.show-more');

	if (items.length && showMoreBtn) {
		if (items.length > 6) {
			showMoreBtn.classList.remove('hidden');
		}

		showMoreBtn.addEventListener('click', function () {
			items.forEach((item) => item.classList.remove('hidden')); // Убираем hidden
			showMoreBtn.classList.add('hidden'); // Скрываем кнопку
		});
	}

	const scrollContainer = document.querySelector(
		'.g-scrolling-carousel .overflow-x-auto'
	);
	if (scrollContainer) {
		let isMouseDown = false;
		let startX, scrollLeft;

		// Прокрутка с помощью колесика мыши
		scrollContainer.addEventListener('wheel', function (e) {
			e.preventDefault(); // Останавливаем стандартное поведение прокрутки
			scrollContainer.scrollLeft += e.deltaY; // Прокручиваем влево или вправо
		});

		// Клик и удержание для прокрутки
		scrollContainer.addEventListener('mousedown', function (e) {
			isMouseDown = true;
			startX = e.pageX - scrollContainer.offsetLeft;
			scrollLeft = scrollContainer.scrollLeft;
		});

		scrollContainer.addEventListener('mouseleave', function () {
			isMouseDown = false;
		});

		scrollContainer.addEventListener('mouseup', function () {
			isMouseDown = false;
		});

		scrollContainer.addEventListener('mousemove', function (e) {
			if (!isMouseDown) return;
			e.preventDefault();
			const x = e.pageX - scrollContainer.offsetLeft;
			const walk = (x - startX) * 3; // Умножаем на коэффициент для скорости прокрутки
			scrollContainer.scrollLeft = scrollLeft - walk;
		});
	}

	const scrollButton = document.getElementById('scrollToTop');

	window.addEventListener('scroll', function () {
		const scroll = window.scrollY;

		if (scroll >= 800) {
			scrollButton.classList.remove('hidden', 'opacity-0');
		} else {
			scrollButton.classList.add('hidden', 'opacity-0');
		}
	});
	scrollButton.addEventListener('click', () => {
		window.scrollTo({ top: 0, behavior: 'smooth' });
	});
});




// api
document.addEventListener('DOMContentLoaded', () => {
	async function uploadDates() {
		const orderForm = document.getElementById('order_form-page');
		if (orderForm && orderForm.dataset.crm) {
			const id = orderForm.dataset.crm;

			fetch('/wp-json/custom/v1/tour_tickets?id=' + id, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
			})
				.then((response) => {
					if (!response.ok) {
						throw new Error('Ошибка при получении данных');
					}
					return response.json();
				})
				.then((parsed) => {
					window.dates = parsed;

					const dateInput = document.querySelector(
						'#order_form-page [type="date"]'
					);
					if (dateInput) {
						dateInput.value = window.dates.min_date;
						dateInput.setAttribute('value', window.dates.min_date);
						dateInput.setAttribute('min', window.dates.min_date);
						dateInput.setAttribute('max', window.dates.max_date);
						dateInput.dispatchEvent(new Event('change'));
					}

					document.dispatchEvent(
						new Event('dates_loaded', { bubbles: true })
					);
				})
				.catch((error) => {
					console.error('Ошибка:', error);
				});
		}
	}


	uploadDates().then(() => {
		document.querySelector('#order_form-page [type="date"]')?.addEventListener('change', function () {
			let val = this.value;
			let options_mosk = '';
			const output = [];

			const uniqueDates = [];
			let allowDates = [];



			if(!!window.dates && !!window.dates.dates) {
				window.dates.dates.forEach((element) => {
					if(!allowDates.includes(element.date)) {
						allowDates.push(element.date);
						uniqueDates.push(element);
					}
					if (val === element.date) {
						if (element.time === element.a1 || !element.a1 ||	element.a1 === 'undefined') {
							options_mosk += `<button type="button" class="time_btn tickets_addr_item" data-id="${element.id}"  data-crm="${element.tour_id}" data-time="${element.time}" data-ticks="${element.tickets}" data-a="a1"> ${element.time} </button>`;
						}
					}
				});

				// Получаем текущую дату и даты на завтра и послезавтра
				const today = new Date();
				const tomorrow = new Date();
				tomorrow.setDate(today.getDate() + 1);
				const dayAfterTomorrow = new Date();
				dayAfterTomorrow.setDate(today.getDate() + 2);

				// Форматируем даты для сравнения
				const todayFormatted = formatDate(today.toISOString().split('T')[0]);
				const tomorrowFormatted = formatDate(tomorrow.toISOString().split('T')[0]);
				const dayAfterTomorrowFormatted = formatDate(dayAfterTomorrow.toISOString().split('T')[0]);

				// Ищем даты в массиве uniqueDates
				const hasToday = uniqueDates.some(item => formatDate(item.date) === todayFormatted);
				const hasTomorrow = uniqueDates.some(item => formatDate(item.date) === tomorrowFormatted);
				const hasDayAfterTomorrow = uniqueDates.some(item => formatDate(item.date) === dayAfterTomorrowFormatted);



				// Добавляем найденные даты в output
				if (hasToday) {
					const todayItem = uniqueDates.find(item => formatDate(item.date) === todayFormatted);
					output.push({
						label: "Сегодня",
						date: formatDate(todayItem.date),
						dateItem: todayItem.date,
					});
				}
				if (hasTomorrow) {
					const tomorrowItem = uniqueDates.find(item => formatDate(item.date) === tomorrowFormatted);
					output.push({
						label: "Завтра",
						date: formatDate(tomorrowItem.date),
						dateItem: tomorrowItem.date,
					});
				}
				if (hasDayAfterTomorrow) {
					const dayAfterTomorrowItem = uniqueDates.find(item => formatDate(item.date) === dayAfterTomorrowFormatted);
					output.push({
						label: "Послезавтра",
						date: formatDate(dayAfterTomorrowItem.date),
						dateItem: dayAfterTomorrowItem.date,
					});
				}

				// Добавляем остальные даты (если есть) с указанием дня недели
				uniqueDates.slice(output.length, output.length + 3).forEach(item => {
					if (output.length < 3) {
						output.push({
							label: getDayOfWeek(item.date),
							date: formatDate(item.date),
							dateItem: item.date,
						});
					}
				});

				 flatpickr('#calendarSelected', {
					inline: true,
					minDate: 'today',
					dateFormat: 'Y-m-d',
					locale: 'ru', // Указываем код языка
					enable:allowDates,
					onChange: function (selectedDates, dateStr) {
						document.querySelector( '#order_form-page [type="date"]').value = dateStr;
						document.querySelector( '#order_form-page [type="date"]').setAttribute('value', dateStr);
						document.querySelector( '#order_form-page [type="date"]').dispatchEvent(new Event('change'));
					},
				});

				// Отображаем кнопки с датами
				const container = document.getElementById('dateButtonsContainer');
				container.innerHTML = '';
				output.forEach(item => {
					const button = document.createElement('button');
					button.type = 'button';
					button.setAttribute('data-value', item.dateItem);
					if (val === item.dateItem) {
						button.className = 'date_btn active';
					} else {
						button.className = 'date_btn';
					}

					button.innerHTML = `
						<span class="self-stretch justify-center items-center inline-flex pointer-events-none">
							<span class="text-lg font-normal leading-normal">${item.label}</span>
						</span>
						<span class="self-stretch justify-center items-center inline-flex pointer-events-none">
							<span class="text-lg font-bold leading-normal">${item.date}</span>
						</span>
					`;
					// Добавляем обработчик события для вывода даты в консоль
					button.addEventListener('click', () => {
						this.value = item.dateItem;
						this.setAttribute('value', item.dateItem);
						this.dispatchEvent(new Event('change'));

						console.log("Выбрана дата:", item.date);
					});
					container.appendChild(button);
				});

				// Если есть дополнительные даты, добавляем кнопку "Выбрать дату"
				if (uniqueDates.length > output.length) {
					document.getElementById('show_calendar').classList.remove('hidden');
				} else {
					document.getElementById('show_calendar').classList.add('hidden');
				}
			}

			document.querySelector('.tickets_addr_items').innerHTML = options_mosk;
			document.querySelector('.tickets_addr_items > *:first-child')?.click();
			//document.querySelector('.dateButtonsContainer > *:first-child')?.click();

			if (!options_mosk) {
				document.querySelector('.tickets_addr_note').textContent = 'Нет билетов';
			}
		});
	});
});

document.addEventListener('DOMContentLoaded', () => {
	document.body.addEventListener('click', (event) => {
		const target = event.target;
		if (!target.classList.contains('date_btn')) return;
		document.querySelectorAll('.date_btn').forEach((el) => {
			console.log(el)
			if (document.querySelector( '#order_form-page [type="date"]').value !== el.getAttribute('data-value')) {
				el.classList.remove('active')
			} else {
				el.classList.add('active');
			}
		}) ;
	});
});

// Функция для преобразования месяца в текстовый формат
const monthToText = (month) => {
	const months = [
		"января", "февраля", "марта", "апреля", "мая", "июня",
		"июля", "августа", "сентября", "октября", "ноября", "декабря"
	];
	return months[month - 1] || "";
};

// Функция для получения дня недели
const getDayOfWeek = (dateString) => {
	const days = ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"];
	const date = new Date(dateString);
	return days[date.getDay()];
};


// Функция для форматирования даты в "день месяц"
const formatDate = (dateString) => {
	const [year, month, day] = dateString.split('-');
	return `${parseInt(day)} ${monthToText(parseInt(month))}`;
};
// Функция для форматирования даты в "день месяц"
const formatDateFull = (dateString) => {
	const [year, month, day] = dateString.split('-');
	return `${parseInt(day)} ${monthToText(parseInt(month))} ${year}`;
};

document.addEventListener('DOMContentLoaded', () => {
	document.body.addEventListener('click', (event) => {
		const target = event.target;
		if (!target.classList.contains('tickets_addr_item')) return;

		document.querySelectorAll('.tickets_addr_item').forEach((el) => el.classList.remove('active'));
		target.classList.add('active');



		const ticks = target.dataset.ticks;
		const a = target.dataset.a;
		const crm_id = target.dataset.crm;
		const t = target.dataset.time;
		const v = target.dataset.id;


		document.getElementById(a)?.click();
		document.querySelector('[name="trip"]').value = v;

		const idCrmInput = document.querySelector('[name="id_crm"]');
		if (idCrmInput.value !== crm_id) {
			idCrmInput.value = crm_id;
			document.getElementById('order_form-page').dataset.crm = crm_id;
			document.getElementById('all-prices').classList.add('loading');

			fetch('/wp-json/custom/v1/get_current_prices', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify({ id: crm_id }),
			})
				.then((response) => response.json())
				.then((data) => {
					updatePrices(data);
					document
						.getElementById('all-prices')
						.classList.remove('loading');
				})
				.catch((error) => console.error('Error:', error));
		}

		document
			.querySelectorAll('.tickets_addr__note')
			.forEach((el) => el.remove());

		document.getElementById('date_and_time').value =  document.querySelector('#order_form-page [type=date]').value + ' ' + t;
		document.querySelectorAll('.selected_info').forEach(function (element) {
			element.innerHTML = formatDate(document.querySelector('#order_form-page [type=date]').value) + ', ' + t;
		});
		document.querySelectorAll('.selected_info_full').forEach(function (element) {
			element.innerHTML = formatDateFull(document.querySelector('#order_form-page [type=date]').value) + ', ' + t;
		});
	});
});

function updatePrices(data) {
	const priceFields = [
		{
			key: 'adult',
			selector: '.form__p_vzroslie',
			inputName: 'price_adults',
		},
		{
			key: 'adult_i',
			selector: '.form__p_vzroslie_inostrancy',
			inputName: 'price_adults_for',
		},
		{
			key: 'kid',
			selector: '.form__p_doshkolniki',
			inputName: 'price_childs',
		},
		{ key: 'old', selector: '.form__p_pensionery', inputName: 'price_old' },
		{
			key: 'school',
			selector: '.form__p_shkolniki',
			inputName: 'price_school',
		},
		{
			key: 'student',
			selector: '.form__p_studenty',
			inputName: 'price_students',
		},
	];

	priceFields.forEach(({ key, selector, inputName }) => {
		const element = document.querySelector(selector);
		const priceInput = document.querySelector(`[name="${inputName}"]`);

		if (data[key]) {
			element.textContent = data[key][1] || data[key][0];
			element.parentElement.nextElementSibling.textContent = data[key][1]
				? `${data[key][0]} руб.`
				: '';
			priceInput.value = data[key][1] || data[key][0];
		}
	});
}

document.addEventListener('DOMContentLoaded', function () {
	const searchForms = document.querySelectorAll('.search-form');

	searchForms.forEach((searchForm) => {
		const searchInput = searchForm.querySelector('input');

		const resultsContainer = document.createElement('ul');
		resultsContainer.className = 'search-results no-scrollbar';
		resultsContainer.style.listStyle = 'none';
		resultsContainer.style.padding = '10px 15px';
		resultsContainer.style.border = '1px solid #ccc';
		resultsContainer.style.maxWidth = '100%';
		resultsContainer.style.display = 'none';
		resultsContainer.style.position = 'absolute';
		resultsContainer.style.backgroundColor = 'white';
		resultsContainer.style.zIndex = '1000';
		resultsContainer.style.top = '35px';
		resultsContainer.style.width = '285px';
		resultsContainer.style.left = '0';
		resultsContainer.style.minWidth = '300px';
		resultsContainer.style.maxHeight = '400px';
		resultsContainer.style.borderRadius = '12px';
		resultsContainer.style.overflowY = 'auto';
		searchForm.appendChild(resultsContainer);

		searchInput.addEventListener('input', function () {
			const query = searchInput.value.trim();
			if (query.length < 2) {
				resultsContainer.style.display = 'none';
				return;
			}

			fetch(
				`/wp-json/custom/v1/search-excursions?search=${encodeURIComponent(query)}`
			)
				.then((response) => response.json())
				.then((data) => {
					resultsContainer.innerHTML = '';
					if (data.length === 0) {
						resultsContainer.style.display = 'none';
						return;
					}
					data.forEach((post) => {
						const listItem = document.createElement('li');
						listItem.style.padding = '5px';
						listItem.style.cursor = 'pointer';

						const link = document.createElement('a');
						link.href = post.link;
						link.innerHTML = post.title;

						listItem.appendChild(link);
						resultsContainer.appendChild(listItem);
					});
					resultsContainer.style.display = 'block';
				})
				.catch((error) => console.error('Ошибка при поиске:', error));
		});
	});

	document.addEventListener('click', function (event) {
		searchForms.forEach((searchForm) => {
			const resultsContainer = searchForm.querySelector('.search-results');
			if (
				resultsContainer &&
				!searchForm.contains(event.target) &&
				!resultsContainer.contains(event.target)
			) {
				resultsContainer.style.display = 'none';
			}
		});
	});
});



function changeForm() {

		let totalAmount = 0;
		let totalCount = 0;
		document.querySelectorAll('.quantity-input').forEach(input => {
			let inputAmountContent = input.parentElement.parentElement.previousElementSibling.querySelector('.price').textContent;
			let inputTotalContent = input.parentElement.nextElementSibling.querySelector('.price');
			let inputAmount = parseInt(inputAmountContent, 10); //цена
			let inputValue = Number(input.value); //кол-тво




			let inputAmountMultiply = inputValue * inputAmount;
			inputTotalContent.textContent = inputAmountMultiply
			totalCount += inputValue;  //общее кол-тво
			totalAmount += inputAmountMultiply; // общая сумма

		});
		document.querySelector('[name=promo]').dispatchEvent(new Event('keyup'));
		document.querySelector('[name=true_price]').value = totalAmount;
		document.querySelector('[name=amount]').value = totalAmount ?? 0;
		document.querySelector('.t_price').textContent = totalAmount ?? 0;
		//document.querySelector('.t_count').textContent = totalCount;


		let val = declOfNum(totalCount, ['билет', 'билета', 'билетов'])
		document.querySelector('.tickets').textContent = totalCount + ' ' + val;


		updateSalePrice();
}
function declOfNum(number, words) {
	return words[(number % 100 > 4 && number % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(number % 10 < 5) ? Math.abs(number) % 10 : 5]];
}
function updateSalePrice() {
	const discountCheckbox = document.querySelector('[name="20percent"]:checked');

	if (discountCheckbox && discountCheckbox.value === 'on') {
		let totalPrice = parseFloat(document.querySelector('.t_price').textContent);
		let totalSalePrice = totalPrice * 0.3;

		document.querySelector('.total-sale_price_count').textContent = Math.round(totalSalePrice);
		document.querySelector('.total-sale_price').classList.remove("hidden");
	} else {
		document.querySelector('.total-sale_price').classList.add("hidden");
	}
}
function checkorderform() {
	const ParForm = document.querySelector('#order_form-page');
	document.querySelectorAll('.error_form_mes').forEach(el => el.remove());

	const phone = ParForm.querySelector('[name=phone]').value.trim();
	const name = ParForm.querySelector('[name=name]').value.trim();
	const mail = ParForm.querySelector('[name=mail]').value.trim();

	let people_count = 0;
	let error = 0;

	const rePhone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
	const reMail = /^[\w-\.]+@[\w-]+\.[a-z]{2,4}$/i;

	const validPhone = rePhone.test(phone);
	const validMail = reMail.test(mail);

	const existingErrorMsg = document.querySelector('.tours-content__form-title + .text-red');
	if (existingErrorMsg) {
		existingErrorMsg.remove();
	}

	document.querySelectorAll('.quantity-input').forEach(input => {
		people_count += parseInt(input.value) || 0;
	});

	if (people_count === 0) {
		const errorMsg = document.createElement('div');
		errorMsg.className = 'text-red';
		errorMsg.textContent = 'Выберите кол-во билетов';
		document.querySelector('.tours-content__form-title').after(errorMsg);
		error = 1;
	} else {
		document.querySelectorAll('.error_form_mes_time.ch_count').forEach(el => el.remove());
	}

	if (!name) {
		const errorMsg = document.createElement('div');
		errorMsg.className = 'error_form_mes error_form_mes_time fio';
		errorMsg.textContent = 'Заполните поле';
		document.querySelector('.fio_field').classList.add('alert');
		error = 1;
	} else {
		document.querySelector('.fio_field').classList.remove('alert');
	}

	if (!phone) {
		document.querySelector('.phones_field').classList.add('alert');
		error = 1;
	} else if (!validPhone) {
		document.querySelector('.phones_field').classList.add('alert');
		error = 1;
	} else {
		document.querySelector('.phones_field').classList.remove('alert');
	}

	if (!mail) {
		document.querySelector('.email_field').classList.add('alert');
		error = 1;
	 }else if (!validMail) {
		document.querySelector('.email_field').classList.add('alert');
		error = 1;
	} else {
		document.querySelector('.email_field').classList.remove('alert');
	}


	return error;
}


document.addEventListener('DOMContentLoaded', function () {
	document.addEventListener('click', (event) => {
		// Проверяем, была ли нажата кнопка увеличения
		if (event.target.closest('.increase-btn')) {
			const label = event.target.closest('label');
			if (label) {
				const input = label.querySelector('.quantity-input');
				if (input) {
					let value = parseInt(input.value, 10);
					value += 1; // Увеличиваем значение
					input.value = value; // Обновляем значение input
				}
			}
			changeForm();
		}

		if (event.target.matches('[name="20percent"]')) {
			updateSalePrice();
		}

		// Проверяем, была ли нажата кнопка уменьшения
		if (event.target.closest('.decrease-btn')) {
			const label = event.target.closest('label');
			if (label) {
				const input = label.querySelector('.quantity-input');
				if (input) {
					let value = parseInt(input.value, 10);
					if (value > 0) { // Не позволяем значению быть меньше 0
						value -= 1; // Уменьшаем значение
						input.value = value; // Обновляем значение input
					}
				}
			}
			changeForm();
		}

		if (event.target.id === 'submit_buy') {
			if(checkorderform()) return;
			const form = document.getElementById('order_form-page')
			const formData = new FormData(form);
			let button = event.target;
			let text = button.querySelector('.btn-text');
			let loader = button.querySelector('.loader');
			console.log(button)
			button.disabled = true;
			text.classList.add('hidden');
			loader.classList.remove('hidden');

			fetch('/wp-content/themes/tw/theme/handler/buy_form.php', {
				method: 'POST',
				headers: {
					// Убедитесь, что REST API доступен без авторизации или передайте токен авторизации.
					//'X-WP-Nonce': wpApiSettings.nonce // Если требуется авторизация
				},
				body: formData,
			})
				.then((response) => {
					if (!response.ok) {
						return response.json().then((err) => {
							throw new Error(
								err.message || 'Ошибка при отправке формы'
							);
						});
					}
					return response.json();
				})
				.then((data) => {
					console.log('Ответ сервера:', data);
					const form = document.querySelector('#order_form-page');
					form.action = data.pay_url;
					form.submit();
				})
				.catch((error) => {
					console.error('Ошибка:', error);
					alert(error.message || 'Что-то пошло не так');
				})
				.finally(() => {
					//document.querySelector('.page-loader').style.display = 'none';
					button.disabled = false;
					text.classList.remove('hidden');
					loader.classList.add('hidden');
				});
		}

		if (event.target.id === 'submit_request') {

			if(checkorderform()) return;
			let button = event.target;
			let text = button.querySelector('.btn-text');
			let loader = button.querySelector('.loader');
			button.disabled = true;
			text.classList.add('hidden');
			loader.classList.remove('hidden');
			const form = document.getElementById('order_form-page')
			const formData = new FormData(form);

			fetch('/wp-content/themes/tw/theme/handler/order_form.php', {
				method: 'POST',
				headers: {
					// Убедитесь, что REST API доступен без авторизации или передайте токен авторизации.
					//'X-WP-Nonce': wpApiSettings.nonce // Если требуется авторизация
				},
				body: formData,
			})
				.then((response) => {
					if (!response.ok) {
						return response.json().then((err) => {
							throw new Error(
								err.message || 'Ошибка при отправке формы'
							);
						});
					}
					return response.json();
				})
				.then((data) => {
					console.log('Ответ сервера:', data);

					setTimeout(()=> {
						const popup = document.querySelector(
							'.popup[data-popup="popup-success-order"]'
						);
						if (popup) {
							popup.classList.remove('hidden');
						}
						// Восстанавливаем кнопку

						document.getElementById('order_form-page').reset();
						button.disabled = false;
						text.classList.remove('hidden');
						loader.classList.add('hidden');
					},10);
				})
				.catch((error) => {
					console.error('Ошибка:', error);
					alert(error.message || 'Что-то пошло не так');
				})
				.finally(() => {
					//document.querySelector('.page-loader').style.display = 'none';
					button.disabled = false;
					text.classList.remove('hidden');
					loader.classList.add('hidden');
				});
		}
	})

});

document.addEventListener("DOMContentLoaded", () => {
	const input = document.querySelector('[name=promo]');
	const promoLoader = document.querySelector('.promo-loader');
	const promoOk = document.getElementById('promo_ok');
	let timeOut;

	if(input) {

		input.addEventListener('keyup', () => {

			if (input.value) {
				promoLoader.classList.add('active');
				clearTimeout(timeOut);
				timeOut = setTimeout(() => myfunc(input.value), 2000);
				promoOk.style.display = 'none';
			} else {
				promoLoader.classList.remove('active');
			}
		});

		input.addEventListener('keydown', () => {
			clearTimeout(timeOut);
		});

		input.addEventListener('change', () => {
			if (!input.value) {
				promoLoader.classList.remove('active');
				promoOk.style.display = 'none';
			}
		});

	}
	async function myfunc(value) {
		const form = document.getElementById('order_form-page');
		if (form) {
			const formData = new FormData(form);
			formData.append('promo', value);

			try {
				const response = await fetch('/wp-content/themes/tw/theme/handler/validate_promo.php', {
					method: 'POST',
					body: formData
				});

				const data = await response.json();
				promoLoader.classList.remove('active');

				if (data.ok) {
					const discount = parseInt(data.minus);
					document.getElementById('discount').dataset.fulldiscount = discount;

					const amountInput = document.querySelector('[name=amount]');
					const newPrice = parseInt(amountInput.value) - discount;
					amountInput.value = newPrice;
					document.querySelector('.t_price').textContent = newPrice;

					promoOk.textContent = `Промокод действителен, скидка ${discount} рублей.`;
					promoOk.style.color = 'green';
					promoOk.style.display = 'block';

					input.readOnly = true;
					updateSalePrice();
				} else {
					promoOk.textContent = data.msg || 'Промокод не действителен.';
					promoOk.style.color = 'red';
					promoOk.style.display = 'block';
				}
			} catch (error) {
				console.error('Ошибка запроса!!:', error);
			}
		}
	}
});


document.addEventListener("DOMContentLoaded", function () {
	const banner = document.getElementById("cookie-banner");
	const acceptBtn = document.getElementById("accept-cookies");
	let userInteracted = false; // Флаг физического взаимодействия

	if (banner && acceptBtn) {
		if (!localStorage.getItem("cookiesAccepted")) {
			banner.classList.remove("hidden");
		}

		// Отмечаем, что пользователь физически кликнул
		document.addEventListener("mousedown", function (event) {
			userInteracted = event.isTrusted;
		});

		acceptBtn.addEventListener("click", function (event) {
			localStorage.setItem("cookiesAccepted", "true");
			banner.classList.add("hidden");
			event.stopPropagation();
		});

		document.addEventListener("click", function (event) {
			if (userInteracted && !banner.contains(event.target)) {

				localStorage.setItem("cookiesAccepted", "true");
				banner.classList.add("hidden");
				event.stopPropagation();
			}
			userInteracted = false; // Сбрасываем флаг после обработки
		});
	}
});

