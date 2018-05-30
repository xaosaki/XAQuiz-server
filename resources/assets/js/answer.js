(function(){
	var formContainer = document.querySelector('#quiz-template-answers');
	if(formContainer){
		var createNewAnswerButton = formContainer.querySelector('#create');
		var btnSelect = document.querySelector('#saveAnswers');
		var errorContainer = document.querySelector('.error-block');
		var errorCount = 0;
		var answersCount = 0;
		var inputResult = document.getElementById('answersContainer');

		if(inputResult.value.length > 0){
			var serverData = JSON.parse(inputResult.value);
			serverData.forEach(function (ans) {
				addAnswer(ans);
			});
			showSaveButton();
		}

		function addAnswer(answer){
			answer = answer || false;
			//создаем input
			var input = document.createElement('textarea');
			input.classList.add('form-control');
			if(answer){
				input.value = answer['text'];
				input.setAttribute('data-question-id', answer['question_id']);
				input.setAttribute('data-id', answer['id']);
			}

			//создаем чекбокс
			var checkbox = document.createElement('input');
			checkbox.type = 'checkbox';
			if(answer){
				checkbox.checked = answer['is_correct'];
			}
			var label = document.createElement('label');
			label.textContent = 'Правильно';
			label.appendChild(checkbox);

			//создаем кнопку удалить
			var buttonDelete = document.createElement('button');
			buttonDelete.type = 'button';
			buttonDelete.textContent = 'Удалить';
			buttonDelete.classList.add('button-delete', 'btn', 'btn-danger','btn-sm');

			//создаем контейнер для input и checkbox
			var containerAnswer = document.createElement('div');
			containerAnswer.classList.add('answer-row');

			//вставляем инпут и чекбокс в контейнер
			containerAnswer.appendChild(input);
			containerAnswer.appendChild(label);
			containerAnswer.appendChild(buttonDelete);

			//вставляем контейнер на страницу
			formContainer.appendChild(containerAnswer);
		}


		//создать новую тему
		createNewAnswerButton.addEventListener('click', function(e){
			++answersCount;
			addAnswer();
			showSaveButton();
		});

		//кнопка удалить строку ответов
		formContainer.addEventListener('click', function(e){
			if(e.target.classList.contains('button-delete')){
				formContainer.removeChild(e.target.parentNode);
				--answersCount;
				hideSaveButton();
			}
		});


		//отправка данных и валидация
		btnSelect.addEventListener('click', function(e) {
			errorContainer.innerHTML = '';
			errorCount = 0;
			var inputCheckboxes = formContainer.querySelectorAll('input[type="checkbox"]');
			var inputAnswers = formContainer.querySelectorAll('textarea');
			var jsonResult = [];

			for(var i=0; i<inputAnswers.length; i++) {
				jsonResult.push({
					text: inputAnswers[i].value,
					question_id: inputAnswers[i].getAttribute('data-question-id') || null,
					id: inputAnswers[i].getAttribute('data-id') || null,
					is_correct: inputCheckboxes[i].checked
				});
			}

			//проверка
			for(var i=0; i<inputAnswers.length; i++) {
				if(inputAnswers[i].value === '') {
					renderError('Заполните все поля');
				}
			}

			var correctAnswers = 0;
			for(var i=0; i<inputCheckboxes.length; i++) {
				if(inputCheckboxes[i].checked){
					++correctAnswers;
				}
			}
			if(correctAnswers === 0){
				renderError('Укажите верный ответ, он должен присутствовать');
			}

			if(!errorCount) {
				inputResult.value = JSON.stringify(jsonResult);
				renderError('Данные обновлены');
			}

		});

		function renderError(text) {
			var errorMes = document.createElement('div');
			errorMes.textContent = text;
			errorContainer.appendChild(errorMes);
			++errorCount;
		}

		function showSaveButton() {
			var buttonBlock = document.querySelector('.part-form-save-block');
			buttonBlock.style.display = 'block';
		}
		function hideSaveButton() {
			var buttonBlock = document.querySelector('.part-form-save-block');
			buttonBlock.style.display = 'none';
		}
	}


})();