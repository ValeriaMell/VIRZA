document.addEventListener('DOMContentLoaded', function () {
    // Маска телефона
    const phoneInput = document.querySelector('input[name="phone"]');
    IMask(phoneInput, {
        mask: '+7 (000) 000-00-00'
    });

    // Обновление текста выбранного файла
    const fileInput = document.querySelector('input[type="file"]');
    const fileNameDisplay = document.getElementById('file-name');
    fileInput.addEventListener('change', function () {
        fileNameDisplay.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'Файл не выбран';
    });

    // Ограничение ввода: Имя и Фамилия — только буквы
    const onlyLetters = /^[а-яА-ЯёЁa-zA-Z]+$/;

    const firstNameInput = document.querySelector('input[name="first_name"]');
    const lastNameInput = document.querySelector('input[name="last_name"]');

    [firstNameInput, lastNameInput].forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^а-яА-ЯёЁa-zA-Z]/g, '');
        });
    });

    // Ограничение ввода email — убрать пробелы и кириллицу
    const emailInput = document.querySelector('input[name="email"]');
    emailInput.addEventListener('input', () => {
        emailInput.value = emailInput.value.replace(/[А-Яа-яЁё\s]/g, '');
    });

    // Валидация и отправка формы
    const form = document.getElementById('vacancyForm');
    const successDiv = document.getElementById('formSuccess');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        form.querySelectorAll('.error-message').forEach(div => div.textContent = '');
        successDiv.textContent = '';
        let isValid = true;

        // Проверки
        const firstName = firstNameInput.value.trim();
        if (!firstName) {
            firstNameInput.nextElementSibling.textContent = 'Пожалуйста, введите имя';
            isValid = false;
        }

        const lastName = lastNameInput.value.trim();
        if (!lastName) {
            lastNameInput.nextElementSibling.textContent = 'Пожалуйста, введите фамилию';
            isValid = false;
        }

        const email = emailInput.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            emailInput.nextElementSibling.textContent = 'Пожалуйста, введите email';
            isValid = false;
        } else if (!emailPattern.test(email)) {
            emailInput.nextElementSibling.textContent = 'Введите корректный email';
            isValid = false;
        }

        const phone = phoneInput.value.trim();
        if (!phone || phone.length < 18) {
            phoneInput.nextElementSibling.textContent = 'Введите полный номер телефона';
            isValid = false;
        }

        const position = form.elements['position'].value;
        if (!position) {
            form.elements['position'].nextElementSibling.textContent = 'Пожалуйста, выберите вакансию';
            isValid = false;
        }

        const resumeInput = form.elements['resume'];
        const resumeErrorDiv = form.querySelector('.resume-upload .error-message');
        if (resumeInput.files.length === 0) {
            resumeErrorDiv.textContent = 'Пожалуйста, выберите файл резюме';
            isValid = false;
        } else {
            const file = resumeInput.files[0];
            if (file.type !== 'application/pdf') {
                resumeErrorDiv.textContent = 'Только PDF файлы разрешены';
                isValid = false;
            }
        }

        if (!isValid) return;

        const formData = new FormData(form);
        fetch('company.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Мы получили ваше резюме. В ближайшее время мы свяжемся с вами!');
                form.reset();
                fileNameDisplay.textContent = 'Файл не выбран';
            } else if (data.errors) {
                for (const [field, message] of Object.entries(data.errors)) {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input && input.nextElementSibling.classList.contains('error-message')) {
                        input.nextElementSibling.textContent = message;
                    } else if (field === 'resume') {
                        resumeErrorDiv.textContent = message;
                    }
                }
            } else {
                alert('Произошла неизвестная ошибка.');
            }
        })
        .catch(() => {
            alert('Ошибка соединения с сервером.');
        });
    });

    // Функция переключения видимости блока вакансий/стажировок
    function toggleCity(cityElement) {
        const vacancies = cityElement.querySelector('.vacancies');
        if (!vacancies) return;
        if (vacancies.style.display === 'block') {
            vacancies.style.display = 'none';
            cityElement.querySelector('.arrow').textContent = '↓';
        } else {
            vacancies.style.display = 'block';
            cityElement.querySelector('.arrow').textContent = '↑';
        }
    }

    // Привязка клика на все города
    document.querySelectorAll('.city').forEach(city => {
        city.addEventListener('click', function () {
            toggleCity(this);
        });
    });
});
