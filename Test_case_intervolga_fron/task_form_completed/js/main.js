//Сохранение value у полей
document.addEventListener("DOMContentLoaded", function() {

    var firstInput = document.querySelectorAll('input')[0];
    var dataForm = firstInput.form;
    var firstSevenElements = Array.prototype.slice.call(dataForm, 0, 8);

    for (var i = 0; i < firstSevenElements.length; i++){
        
        if(firstSevenElements[i].value === '') {
            firstSevenElements[i].value = window.sessionStorage.getItem(firstSevenElements[i].name) || firstSevenElements[i].value;
        }

        firstSevenElements[i].addEventListener('input', function(event) {
            window.sessionStorage.setItem(event.target.name, event.target.value);
        });
    }

});

// Вылидация полей формы
var form = document.querySelector('.form')
var validateBtn = form.querySelector('.form-block__button--submit')

var gosNumber = form.querySelector('#gos')
var transport = form.querySelector('#transport')
var arrival = form.querySelector('#arrival')
var fio = form.querySelector('#fio')
var passportSeries = form.querySelector('#passport-series')
var passportNumber = form.querySelector('#passport-number')
var whom = form.querySelector('#whom')
var when = form.querySelector('#when')

var fields = form.querySelectorAll('.field')

var removeValidation = function() {

    var errors = form.querySelectorAll('.error')

    for (var i = 0; i < errors.length; i++) {
        errors[i].remove()
    }

}

var generatorError = function (text) {
    var error = document.createElement('span')
    error.className='error'
    error.style.color = 'red'
    error.style.padding = '0 0 10px 0'
    error.style.fontSize = '18px'
    error.innerHTML = text
    return error
}

// var checkFieldsPresence = function () {
//     for (var i = 0; i < fields.length; i++) {
//         if(!fields[i].value) {
//             if(!fields[i].parentElement.querySelector('.error')) {
//                 var error = generatorError('Поле должно быть заполнено!');
//                 form[i].parentElement.insertBefore(error, fields[i]);
//             }
//         } else {
//             var error = fields[i].parentElement.querySelector('.error');
//             if(error) {
//                 error.remove();
//             }
//         }
//     }
// }

var checkGosNumber = function () {
    var gosNumberCheck =  gosNumber.value
    if(gosNumberCheck.length <= 7) {
        var error = generatorError('Гос-номер меньше 8-ми символов!')
        gosNumber.parentElement.insertBefore(error, gosNumber)
    }
}


var checkTransport = function() {
    var checkTransportCheck = transport.value
    if(checkTransportCheck.length <= 1) {
        var error = generatorError('Название машины меньше 2-х символов!')
        transport.parentElement.insertBefore(error, transport)
    } else if(checkTransportCheck.length >= 28) {
        var error = generatorError('Название машины больше 28-ми символов!')
        transport.parentElement.insertBefore(error, transport)
    }
}

var checkFio = function() {
    var fioCheck = fio.value
    if(fioCheck.length <= 3) {
        var error = generatorError('ФИО меньше 4-х символов!')
        fio.parentElement.insertBefore(error, fio)
    } else if(fioCheck.length >= 141) {
        var error = generatorError('ФИО больше 140-ка символов!')
        fio.parentElement.insertBefore(error, fio)
    }
}

var checkPassportSeries = function() {
    var passportSeriesCheck = passportSeries.value
    if(passportSeriesCheck.length <= 4) {
        var error = generatorError('Серия меньше 4-х символов!')
        passportSeries.parentElement.insertBefore(error, passportSeries)
    }
}

var checkPassportNumber = function() {
    var passportNumberCheck = passportNumber.value
    if(passportNumberCheck.length <= 5) {
        var error = generatorError('Номер меньше 5-ти символов!')
        passportNumber.parentElement.insertBefore(error, passportNumber)
    }
}

var checkWhom = function() {
    var whomCheck = whom.value
    if(whomCheck.length <= 4) {
        var error = generatorError('Кол-во символов меньше 5-ти символов!')
        whom.parentElement.insertBefore(error, whom)
    } else if(whomCheck.length >= 101) {
        var error = generatorError('Кол-во символов больше 100 символов!')
        whom.parentElement.insertBefore(error, whom)
    }
}

var checkWhen = function() {
    var whenCheck = when.value
    if(whenCheck.length <= 9) {
        var error = generatorError('Количество символов меньше 7-ми символов!')
        when.parentElement.insertBefore(error, when)
    }
}

form.addEventListener('submit', function(event) {

    event.preventDefault()

    removeValidation()

    // checkFieldsPresence()

    checkGosNumber()

    checkTransport()

    checkFio()

    checkPassportSeries()

    checkPassportNumber()

    checkWhom()

    checkWhen()

    var errors = form.querySelectorAll('.error')

    if(errors.length == 0){
        alert('Форма успешно отправилась!')
    }

})

//открыть-закрыть форму
var btn = document.querySelector('.form__item--svg');
var blockBtn = document.querySelector('.block__item--open-form')

btn.addEventListener('click', function() {
    form.id = 'show'
    blockBtn.id = 'open'
})

blockBtn.addEventListener('click', function() {
    form.id = 'open'
    blockBtn.id = 'show'
})

//Макски для полей
document.addEventListener('DOMContentLoaded', () => {

    const mask = (dataValue, options) => {
        const elements = document.querySelectorAll(`[data-mask="${dataValue}"]`)
        if (!elements) return

        elements.forEach(el => { 
        IMask(el, options)
        })
    }

    mask('passport-series', {
        mask: '00 00' 
    })

    mask('passport-number', {
        mask: '000000' 
    })

    mask('when', {
        mask: Date,
        min: new Date(1950, 0, 1),
        max: new Date(2024, 12, 12),
    })

    mask('fio', {
        mask: /^[a-zа-я]{0,150}$/i
    })

    mask('whom', {
        mask: /^[a-zа-я]{0,150}$/i
    })

})

$(document).ready(function(){
    $("#gos").inputmask("A{1}9{3}A{2}9{2,3}",{ "placeholder": "" });
});