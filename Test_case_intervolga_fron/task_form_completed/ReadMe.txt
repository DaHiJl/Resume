#Тестовое задание на frontend (Создание формы)

##Описание
Этот репозиторий содержит решение тестового задания по frontend разработке. В этом проекте создана веб-страница, на которой размещена форма

##Поставленная задача
- Необходимо было реализовать форму
- Все поля формы обязательны для заполения
- Поля формы. Госномер, паспорт, дата имеют свою маску заполнения. (Нельзя ввести не правильный номер или буквы в серию паспорта)
- Форма отправляется только если все поля заполнены и валидны
* После перезагрузки страницы результат заполнения формы не теряется

##Решение
- Была сверстана форма
- Все поля формы сделаны обязательными для заполнения
- Для полей формы - Госномер, паспортные данные и когда выдан были сделаны  отдельные маски
- Было выполнено условие - форма отправляется только если все поля заполнены и валидны, для этого была написана валидация
- Выполнена дополнительное задание - при перезагрузке страницы результат заполнения формы не теряется, а остается

##Установка и запуск
1. Клонировать репозиторий
2. Открыть файл intervolga_form.html в веб-браузере

#Структура проекта
- intervolga_form.html: Основной файл веб-приложения. За основу взята методология Бэм
- Папка scss состоящая из:
	base.scss - обнуление стилей браузера
	breakpoint.scss и vars.scss - загатовка адаптивной верстки (Была реализована и взята со второй задачи)
	color.scss - переменные с цветами
	mixin.scss - примеси для основного файла main.scss, чтобы уменьшить повторяющейся код при верстке
	main.scss - основной файл со стилями
- Папка js состоящая из:
	imask - библиотека для создания масок у полей
	inputmask - библиотека для создания масок у полей, была добавлена для решения проблемы кастомизации маски у поля Госномер
	jquery - библиотека для сокращения js кода и для удобства
	main.js - файл со скриптами (валидация полей формы, сохранение переменных после перезагрузки страницы, маски для полей)
- Папка svg - для хранения изображений



