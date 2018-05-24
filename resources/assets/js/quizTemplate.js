(function(){
	var formContainer = document.querySelector('#quiz-template-subjects');
	if(formContainer){
		var serverSubjects = JSON.parse(formContainer.getAttribute('data-subjects'));
		var createNewThemeButton = formContainer.querySelector('#create');
		var btnSelect = document.querySelector('#saveSubjects');
		var themeCountFlag=0;
		var inputResult = document.getElementById('subjectsContainer');

		if(inputResult.value.length > 0){
			var serverData = JSON.parse(inputResult.value);
			serverData.forEach(function (sbj) {
				addThemeSelection(sbj);
			});
			showSaveButton();
		}

		function addThemeSelection(subject){
			subject = subject || false;
			var select = document.createElement('select');
			select.classList.add('form-control');
			for(var i = 0; i<serverSubjects.length; i++) {
				var option = document.createElement('option');
				option.value = serverSubjects[i]['id'];
				option.textContent = serverSubjects[i]['name'];
				if(subject && serverSubjects[i]['id'] === subject['id']){
					option.selected = true;
					option.defaultSelected = true;
				}
				select.appendChild(option);
			}

			//создаем input
			var input = document.createElement('input');
			input.type = 'number';
			input.classList.add('form-control');
			if(subject){
				input.value = subject['questions_count'];
			}
			var submit = document.querySelector('#submit');

			//создаем контейнер для select и input
			var containerTheme = document.createElement('div');
			containerTheme.classList.add('subject-group');
			containerTheme.classList.add('js-subject-group');
			containerTheme.appendChild(select);
			containerTheme.appendChild(input);

			formContainer.appendChild(containerTheme);
		}


		//создать новую тему
		createNewThemeButton.addEventListener('click', function(e){
			++themeCountFlag;

			if(!(themeCountFlag > serverSubjects.length)) {
				addThemeSelection();
			}
			showSaveButton();

		});

		//отправка данных и валидация
		btnSelect.addEventListener('click', function(e) {
			var errorCount = 0;
			var errorContainer = document.querySelector('.error-block');
			errorContainer.innerHTML = '';
			//находим допустимое количество вопросов
			var subjectRows = formContainer.querySelectorAll('.js-subject-group');



			var inputs = formContainer.querySelectorAll('input');
			for(var i = 0; i<inputs.length; i++) {
				if(inputs[i].value === ''){
					renderError('Заполните все поля');
					return false;
				}
			}

			var selectes = formContainer.querySelectorAll('select');
			var objValuesSelect = {};
			for(var i=0; i<selectes.length; i++) {
				if(typeof objValuesSelect[selectes[i].value] == 'undefined') {
					objValuesSelect[selectes[i].value] = 0;
				} else {
					renderError('Выберите разные темы');
					return false;
				}
			}

			subjectRows.forEach(function(elem){
				var subjectSelect = elem.querySelector('select');
				var subjectId = subjectSelect.value;
				var subjectInput = elem.querySelector('input');
				var questionsCount = subjectInput.value;

				serverSubjects.forEach(function (sbj) {
					if(sbj['id'] === parseInt(subjectId)){
						if(sbj['questions_count'] < parseInt(questionsCount)){
							renderError('Количество вопросов в теме '+sbj['name']+' — '+sbj['questions_count'])
						}
					}
				})
			});

			function renderError(text) {
				var errorMes = document.createElement('div');
				errorMes.textContent = text;
				errorContainer.appendChild(errorMes);
				++errorCount;
			}


			// for(var i = 0; i<serverSubjects.length; i++) {
			//
			// 	if(serverSubjects[i].id === value){
			// 		questionsCount = serverSubjects[i]['questions_count'];
			// 		if(inputCount > questionsCount) {
			// 			errorMes = document.createElement('div');
			// 			errorMes.textContent = 'Количество вопросов больше, чем есть';
			// 			formContainer.appendChild(errorMes);
			// 			++errorCount;
			// 		}
			// 		break;
			// 	}
			// }

			//проверка


			if(!errorCount) {
				var jsonResult = [];

				for (var i = 0; i<selectes.length; i++) {
					var objResult = {};
					objResult.id = selectes[i].value;
					objResult['questions_count'] = inputs[i].value;
					jsonResult.push(objResult);
				}

				inputResult.value = JSON.stringify(jsonResult);
				renderError('Темы обновлены')

			}

		});

		function showSaveButton() {
			var buttonBlock = document.querySelector('.part-form-save-block');
			buttonBlock.style.display = 'block';
		}
	}


})();