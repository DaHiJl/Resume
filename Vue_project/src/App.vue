<script setup>
import { reactive, ref , computed } from 'vue'; 
import useVuelidate from '@vuelidate/core'
import {helpers, minLength, maxLength, email, numeric, sameAs, required} from '@vuelidate/validators'
import axios from 'axios';
import CustomInput from './components/Custominput.vue';
import Checkbox from './components/Checkbox.vue';

const review = reactive({
  login: '',
  password: '',
  passwordConfirm: '',
  phone: '',
  city: '',
  citys: [
            { value: 'Moscov', label: "Москва"},
            { value: 'Volgograd', label: "Волгоград"},
            { value: 'Omsk', label: "Омск"},
            { value: 'Ekaterinburg', label: "Екатеринбург"},
            { value: 'Tomsk', label: "Томск"},
          ],
  email: '',
  gender: true,
  photo: null,
  photo_look: null,
  consent: false,
})

// const file_look = null;
// const file = null;

const uploadFile = (e) => {
  const file_look = e.target.files[0].name;
  review.photo_look = file_look;
  const file = e.target.files[0];
  review.photo = file;
  console.log(review.photo)
}


const isShownPhoto = ref(false)

const togglePhoto = () => {
  return isShownPhoto.value = !isShownPhoto.value;
}

// const errorPasword = ref('')

const nameField = ref('')
const passwordField = ref('')
const passwordFieldConfirm = ref('')
const phoneField = ref('')
const emailField = ref('')
const checkBoxActive = ref(false)

// const passAlpha = helpers.regex("((?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,20})/");

const passAlpha = (value) => {
  if(!/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/g.test(value)){
    return false
  } else {
    return true
  }
}

const checkCheckbox = (value) => {
  if(value == true) {
    return true
  } else {
    return false
  }
}

const rules = computed(() => ({
  nameField: {
    minLength: helpers.withMessage('Логин менее 8-ми символов', minLength(8)),
    required: helpers.withMessage('Логин не введен', required)
  },
  passwordField: {
    minLength: helpers.withMessage('Пароль менее 8-ми символов', minLength(8)),
    passwordField: helpers.withMessage('Пароль введен не корректно!', passAlpha),
    required: helpers.withMessage('Пароль не введен', required)
  },
  passwordFieldConfirm: {
    sameAsPassword: helpers.withMessage('Пароли не совпадают', sameAs(passwordField.value)),
    minLength: helpers.withMessage('Пароль менее 8-ми символов', minLength(8)),
    passwordField: helpers.withMessage('Пароль введен не корректно!', passAlpha),
    required: helpers.withMessage('Пароль не введен', required)
  },
  emailField: {
    email: helpers.withMessage('Почта введена некорректно', email),
    required: helpers.withMessage('Почта не введена', required)
  },
  phoneField: {
    required: helpers.withMessage('Телефон не введен', required)
  },
  checkBoxActive: {
    checkBoxActive: helpers.withMessage('Согласие не дано', checkCheckbox)
  }
}))

const v = useVuelidate(rules, {nameField, emailField, passwordField, passwordFieldConfirm, phoneField, checkBoxActive})

const submit = () => {
  // console.log('Submit!');

  v.value.$touch()
  console.log(v.value.$error)
  if (v.value.$error) return
  alert('Forma complited')

  axios.post('http://127.0.0.1:8000/reg/user', review, {
    headers: {
      'Content-Type': 'multipart/from-data',
    },
    data:{
      login: nameField,
      password: passwordField,
      repeat_password: passwordFieldConfirm,
      phone: phoneField,
      email: emailField,
      photo: review.photo,
      city: review.city,
      gender_id: Number(checkBoxActive),
    }
  });

  // axios.post('/api/review', review, {
  //   headers: {
  //     'Content-Type': 'multipart/from-data'
  //   }
  // });

  // .then((res) => {
  //   console.log(res);
  // })
  // .catch((err) => {
  //   console.log(err);
  // })
  // .finally(() => {
  //   console.log('End');
  // })
}

</script>

<template>
  <div class="ma overflow-hidden pt-10 pb-10 submain-background-color">
    <div class="container ma b-rd-10 main-background-color">
      <div class="registration-body flex justify-center">
        <div class="registration-logo flex justify-center flex-col mr-10">
          <img class="logo-shaman" src="./assets/logoShaman.svg" />
          <div class="title-shaman text-center font-size-30 text-color-white">
            SHAMAN
          </div>
        </div>
        <form class="registration-form mt-20" @submit.prevent.stop="submit">
          <div class="flex mb-5 justify-center font-size-6 error-message-color-text">
            <label>Поля, отмеченные * являются обязательными</label>
          </div>
          <CustomInput
            :requiredStar="true"
            name="login"
            placeholder="Логин "
            v-model:value="v.nameField.$model"
            :error="v.nameField.$errors"
          />
          <CustomInput
            :requiredStar="true"
            :tooltip="true"
            tooltiptext="Пароль должен состоять из <br> латинских символов. <br> Должен содержать знаки и <br> заглавные буквы"
            name="password"
            type="password"
            placeholder="Пароль "
            v-model:value="v.passwordField.$model"
            :error="v.passwordField.$errors"
          />
          <CustomInput
            :requiredStar="true"
            name="passwordConfirm"
            type="password"
            placeholder="Повторите пароль "
            v-model:value="v.passwordFieldConfirm.$model"
            :error="v.passwordFieldConfirm.$errors"
          />
          <CustomInput
            :requiredStar="true"
            :tooltip="true"
            tooltiptext="Номер должен вводится <br> без кода страны"
            name="phone"
            placeholder="+7"
            type="tel"
            mask="+7 ### ### ## ## "
            v-model:value="v.phoneField.$model"
            :error="v.phoneField.$errors"
          />
          <div class="flex mb-5 mt-5 ml-5">
            <div class="relative city w-full">
              <select name="" id="city" class="input-city" v-model="review.city">
                <option selected disabled value="">Город: </option>
                <option v-for="option in review.citys" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </div>
          </div>
          <CustomInput
            :requiredStar="true"
            name="email"
            placeholder="Почта "
            v-model:value="v.emailField.$model"
            :error="v.emailField.$errors"
          />
          <div class="flex mb-5 gender-body flex-col ml-13">
            <label class="gender-label font-size-8 text-color-white">Пол: </label>
            <div class="gender-block flex grid-items-center">
              <input 
                class="custom-radio" 
                type="radio" 
                name="gender" 
                id="gender-male" 
                :value="true" 
                v-model.trim="review.gender"
              >
              <label for="gender-male" class="gender-label font-size-8 text-color-white sex mr-16">Муж</label>
              <input 
                class="custom-radio" 
                type="radio" 
                name="gender" 
                id="gender-femile" 
                :value="false" 
                v-model.trim="review.gender"
              >
              <label for="gender-femile" class="gender-label font-size-8 text-color-white sex mr-8">Жен</label>
            </div>
          </div>
          <div class="flex mb-5 photo-body flex-col">
            <div class="photo-block flex justify-between relative  mb-5">
              <div>
                <img src="./assets/star.svg" />
                <label class="photo-label font-size-8 text-color-white ml-8">Фото паспорта: </label>
              </div>
              <div v-show="isShownPhoto" class="tooltip">Прикрепите фото первой <br> страницы паспорта.Фото <br> должно быть в форматах <br> jpg, jpeg, png, bmp, <br> gif, svg или webp</div>
              <img @mouseenter="togglePhoto" @mouseleave="togglePhoto" class="photo-margin" src="./assets/question mark.svg">
            </div>
            <input 
              type="file" 
              id='upload' 
              accept="image/x-png,image/gif,image/jpeg,image/jpg,image/bmp,image/svg,image/webp"
              @change="uploadFile"
            >
            <label for='upload'  class="input-file"><img src="./assets/upload.svg"></label>
          </div>
          <div class="flex mb-5 justify-center font-size-6 error-message-color-text namephoto">
            {{ review.photo_look }}
          </div>
          <Checkbox
            id="consent"
            name="consent"
            type="checkbox"
            v-model:checked="v.checkBoxActive.$model"
          />
          <TransitionGroup>
              <div v-for="element of v.checkBoxActive.$errors" :key="element.$uid" class="mb-5 flex mt-5 font-size-8 errorMessage error-message-color-text">
                  {{ element.$message }}
              </div>
          </TransitionGroup>
          <button type="submit" class="form-button-click ml-12 cursor-pointer border-rd-20 border-0 text-color-white submain-background-color font-size-8">Зарегистрироваться</button>
          <p class="loginIn text-color-white underline text-center mt-16 mb-24 mr-20 font-size-6">
            <router-link to="#">Уже есть аккаунт? Войти</router-link>
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Настройка кастомных radio-battons */
  /* для элемента input c type="radio" */
  .custom-radio {
    position: absolute;
    z-index: -1;
    opacity: 0;
  }
  /* для элемента label связанного с .custom-radio */
  .custom-radio+label {
    display: inline-flex;
    align-items: center;
    user-select: none;
  }
  /* создание в label псевдоэлемента  before со следующими стилями */
  .custom-radio+label::before {
    content: '';
    display: inline-block;
    height: 38px;
    width: 38px;
    flex-shrink: 0;
    flex-grow: 0;
    border: 1px solid #373737;
    border-radius: 50%;
    margin-right: 0.5em;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50% 50%;
    background: #373737;
  }
  /* стили при наведении курсора на радио */
  .custom-radio:not(:disabled):not(:checked)+label:hover::before {
    border-color: #F7F4A4;
  }
  /* стили для активной радиокнопки (при нажатии на неё) */
  .custom-radio:not(:disabled):active+label::before {
    background-color: #F7F4A4;
    border-color: #F7F4A4;
  }
  /* стили для радиокнопки, находящейся в фокусе */
  .custom-radio:focus+label::before {
    box-shadow: 0 0 0 0.2rem rgba(239, 255, 57, 0.25);
  }
  /* стили для радиокнопки, находящейся в фокусе и не находящейся в состоянии checked */
  .custom-radio:focus:not(:checked)+label::before {
    border-color: #80bdff;
  }
  /* стили для радиокнопки, находящейся в состоянии checked */
  .custom-radio:checked+label::before {
    border-color: #F7F4A4;
    background-color: #F7F4A4;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%2ffff'/%3e%3c/svg%3e");
  }
  /* стили для радиокнопки, находящейся в состоянии disabled */
  .custom-radio:disabled+label::before {
    background-color: #e9ecef;
  }

/* Цвет текста у inputs в разных браузерах */
::-webkit-input-placeholder {
  color: #ffffff;
  opacity: 0.5;
}
:-moz-placeholder {
  color: #ffffff;
  opacity: 0.5;
}
::-moz-placeholder {
  color: #ffffff;
  opacity: 0.5;
}
:-ms-input-placeholder {
  color: #ffffff;
  opacity: 0.5;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}
/* Кастомный тултип */
.tooltip{
  padding: 10px;
  border-top-right-radius: 20px;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  border: 2px solid #F7F4A4;
  position: absolute;
  top: 50%;
  left: 90%;
  width: 347px;
  z-index: 2;
  color: #FFFFFF;
  font-size: 24px;
  text-align: center;
  background-color: #000000;
}
/* Кастомное выпадающие меню */
.input-city{
  padding: 12px 32px;
  margin: 0 18px;
  border-radius: 30px;
  background-color: #5c5c5c;
  border: 0;
  font-size: 32px;
  width: 453px;
  color: #FFFFFF;
  appearance: none;
  background: url(./assets/dropmenu.svg) no-repeat right rgba(55, 55, 55, 1);
  background-position-x: calc(100% - 20px);
  opacity: 0.78;
}
/* Кастомная загрузка файла */
.input-file{
  display: flex;
  justify-content: center;
  text-align: center;
  background: #373737;
  height: 102px;
  width: 63%;
  border-radius: 30px;
  margin: 0 0 0 50px;
  padding: 20px 26px;
}
.form-button{
  margin: 0 0 0 50px;
}
.form-button-click{
  /* width: 85%; */
  padding: 10px 74px 14px 74px;
  background: #373737;
  font-family: Inter,  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
}
#upload{
  display: none;
}
.loginIn a{
  color: #ffffff;
}
.tooltip-top{
  top: -190px;
}
.tooltip-bottom{
  top: -150px;
}
.input{
  background: #373737;
}
.errorMessage{
  margin-left: 52px;
}
.borderErrors{
  border: 2px solid #F47A7A;
}
.logo-shaman{
  max-width: 100%;
}
.widthchecbox{
  max-width: 610px;
}
.photo-margin{
  margin-right: 84px;
}
.phoneflex{
  align-items: flex-start;
}
.tooltip-right{
  right: -46%;
}
.starPhone{
  margin-top: 10px;
}
.starPhone2{
  margin-top: 20px;
}
.namephoto{
  margin-right: 70px;
}
@media (max-width: 1440px) {
  .container{
    display: flex;
    justify-content: center;
  }
  .registration-body{
    flex-direction: column;
  }
  .registration-logo{
    margin-right: 0;
    margin-top: 20px;
  }
  .registration-form{
    margin-top: 20px;
  }

  .photo-margin {
    margin-right: 10px;
  }
  .tooltip{
    left: 0;
    top: 100%;
    z-index: 999;
    font-size: 32px;
    width: 100%;
  }
}
@media (max-width: 768px) {
  .logo-shaman{
    display: none;
  }
  .title-shaman{
    font-size: 5rem;
  }
  .tooltip{
    left: -2%;
  }
}
</style>