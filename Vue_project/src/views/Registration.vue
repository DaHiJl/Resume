<script setup>
import { reactive, ref , computed } from 'vue'; 
import useVuelidate from '@vuelidate/core'
import {helpers, minLength, maxLength, email, numeric, sameAs, required} from '@vuelidate/validators'
import axios from 'axios';
import CustomInput from '@/components/Custominput.vue';
import Checkbox from '@/components/Checkbox.vue';
import router from '@/router';

const nameField = ref('')
const passwordField = ref('')
const passwordFieldConfirm = ref('')
const phoneField = ref('')
const cityField = ref('')
const emailField = ref('')
const checkBoxActive = ref(false)

const errorPhoto = ref('')

const isShownPhoto = ref(false)
const isShownDropdown = ref(false)
const isShownDropdownPlaceholder = ref(true)

const review = reactive({
  login: nameField,
  password: passwordField,
  repeat_password: passwordFieldConfirm,
  phone: phoneField,
  city: '',
  citys: [
            { value: '', label: "Не выбирать"},
            { value: 'Moscow', label: "Москва"},
            { value: 'Volgograd', label: "Волгоград"},
            { value: 'Omsk', label: "Омск"},
            { value: 'Ekaterinburg', label: "Екатеринбург"},
            { value: 'Tomsk', label: "Томск"},
            { value: 'Vladivostok', label: "Владивосток"},
            { value: 'Kamishin', label: "Камышин"},
            { value: 'Krasnodar', label: "Краснодар"},
            { value: 'Nishniy Novgorod', label: "Нижний новгород"},
            { value: 'Kaliningrad', label: "Калининград"},
          ],
  email: emailField,
  gender_id: 0,
  photo: null,
  photo_look: null,
  consent: false,
  errorPhotoViewPer: '',
})

const uploadFile = (e) => {
  const file_look = e.target.files[0].name;
  const file = e.target.files[0];
  if(/\.[^\.]*$/.exec(file_look)[0] == '.jpg' || /\.[^\.]*$/.exec(file_look)[0] == '.jpeg' || /\.[^\.]*$/.exec(file_look)[0] == '.png' || /\.[^\.]*$/.exec(file_look)[0] == '.bmp' || /\.[^\.]*$/.exec(file_look)[0] == '.gif' || /\.[^\.]*$/.exec(file_look)[0] == '.svg' || /\.[^\.]*$/.exec(file_look)[0] == '.webp'){
    review.photo = file;
    review.photo_look = file_look;
    review.errorPhotoViewPer = '';
    // return errorPhoto.value = !errorPhoto.value;
  } else {
    review.errorPhotoViewPer = 'Неверный формат файла!';
    review.photo_look = null;
    review.photo = null;
  }
  // console.log(review.photo);
}

const uploadFileClick = () => {
  if(review.photo == null ){
    review.errorPhotoViewPer = 'Загрузите файл!';
  }
}

const togglePlaceholder = (e) => {
  if (e.target.localName=="span")
  {
    console.log(e)
    if(e.target.attributes.value.nodeValue=="")
    {
      cityField.value = e.target.innerText
      isShownDropdownPlaceholder.value=true
      review.city=e.target.attributes.value.nodeValue
    }
    else{
      cityField.value = e.target.innerText
      isShownDropdownPlaceholder.value=false
      review.city=e.target.attributes.value.nodeValue
    }
  }
  else{

    if(e.target.children[0].attributes.value.nodeValue=="")
    {
      cityField.value = e.target.innerText
      isShownDropdownPlaceholder.value=true
      review.city=e.target.children[0].attributes.value.nodeValue
    }
    else{
      cityField.value = e.target.innerText
      isShownDropdownPlaceholder.value=false
      review.city=e.target.children[0].attributes.value.nodeValue
    }
  }
}


const togglePhoto = () => {
  return isShownPhoto.value = !isShownPhoto.value;
}

const passAlpha = (value) => {
  if(!/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/g.test(value)){
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
    minLength: helpers.withMessage('Логин менее 8-ми символов!', minLength(8)),
    required: helpers.withMessage('Логин не введен!', required)
  },
  passwordField: {
    minLength: helpers.withMessage('Пароль менее 8-ми символов!', minLength(8)),
    passwordField: helpers.withMessage('Пароль введен некорректно!', passAlpha),
    required: helpers.withMessage('Пароль не введен!', required)
  },
  passwordFieldConfirm: {
    sameAsPassword: helpers.withMessage('Пароли не совпадают!', sameAs(passwordField.value)),
    minLength: helpers.withMessage('Пароль менее 8-ми символов!', minLength(8)),
    passwordField: helpers.withMessage('Пароль введен некорректно!', passAlpha),
    required: helpers.withMessage('Пароль не введен!', required)
  },
  emailField: {
    email: helpers.withMessage('Почта введена некорректно!', email),
    required: helpers.withMessage('Почта не введена!', required)
  },
  phoneField: {
    required: helpers.withMessage('Телефон не введен!', required),
    minLength: helpers.withMessage('Телефон менее 10-ти цифр!', minLength(16)),
  },
  checkBoxActive: {
    checkBoxActive: helpers.withMessage('Согласие не дано!', checkCheckbox)
  }
}))

const v = useVuelidate(rules, {nameField, emailField, passwordField, passwordFieldConfirm, phoneField, checkBoxActive})

const submit = () => {
  v.value.$touch()
  console.log(review.photo)
  if(review.photo == null) {
    review.errorPhotoViewPer = 'Загрузите файл!';
    return
  }
  if (v.value.$error == true) return

  axios.get('http://127.0.0.1:8000/reg/user',{
    params: {
      login: review.login
    }
  })

  .then(function (response) {
    console.log(response)
    if(response.status==200)
    {
      alert('Пользователь с таким логином уже существует')
    }
    else if(response.status==203)
    {
      const formData = new FormData();
      formData.append('login', review.login);
      formData.append('password', review.password);
      formData.append('repeat_password', review.repeat_password);
      formData.append('phone', review.phone.replace(/\s/g, ""));
      formData.append('email', review.email);
      formData.append('photo', review.photo);
      formData.append('city', review.city);
      formData.append('gender_id', review.gender_id);

      axios.post('http://127.0.0.1:8000/reg/user', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
      .then(function (response) {
        if(response.status==202)
        {
          router.push({ path: '/errorpackage'})
        }
        else if(response.status==201)
        {
          router.push({ path: '/complete'})
        }
      });
    }
    else if(response.status==201)
    {
      router.push({ path: '/errorpackage'})
    }
  });


}
</script>
<template>
        <div class="registration-body flex justify-center position-relative">
          <router-link to="/mainpage" class="position-absolute top-10 left-10"><img class="arrow" src="../assets/Arrow 2.svg"></router-link>
          <div class="registration-logo flex justify-center flex-col mr-10">
            <img class="logo-shaman" src="../assets/logoShaman.svg" />
            <div class="title-shaman text-center font-size-30 text-color-white">
              SHAMAN
            </div>
          </div>
          <div class="registration">
            <form class="registration-form mt-20" @submit.prevent.stop="submit">
              <div class="mandatory-block">
                <div class="flex mb-5 justify-center font-size-6 mandatory-label error-message-color-text">
                  <label>Поля, отмеченные * являются обязательными</label>
                </div>
              </div>
            <!-- <div class="flex mb-5 justify-center font-size-6 mandatory-label error-message-color-text">
              <label>Поля, отмеченные * являются обязательными</label>
            </div> -->
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
            <div @click="isShownDropdown=!isShownDropdown" class="custom-dropdown">
              <div v-show="isShownDropdownPlaceholder" class="custom-dropdown-placeholder text-color-white">
                Город
              </div>
              <div v-show="!isShownDropdownPlaceholder" class="custom-dropdown-placeholder-city text-color-white">
                {{cityField}}
              </div>
              <div v-show="isShownDropdown" class="custom-dropdown-list">
                <div v-show="isShownDropdown" v-for="option in review.citys" class="custom-dropdown-list-item" @click="togglePlaceholder">
                  <span :value="option.value">{{ option.label }}</span>
                </div>
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
                  :value=0
                  v-model.trim="review.gender_id" 
                >
                <label for="gender-male" class="gender-label font-size-8 text-color-white sex mr-16">Муж</label>
                <input 
                  class="custom-radio" 
                  type="radio" 
                  name="gender" 
                  id="gender-femile" 
                  :value=1
                  v-model.trim="review.gender_id" 
                >
                <label for="gender-femile" class="gender-label font-size-8 text-color-white sex mr-8">Жен</label>
              </div>
            </div>
            <div class="flex mb-5 photo-body flex-col">
              <div class="photo-block flex relative  mb-5">
                <div class="photo-block-label">
                  <img src="../assets/star.svg" class="star-photo"/>
                  <label class="photo-label font-size-8 text-color-white ml-8">Фото паспорта: </label>
                </div>
                <div v-show="isShownPhoto" class="tooltip tooltip-photo">Прикрепите фото первой <br> страницы паспорта.Фото <br> должно быть в форматах <br> jpg, jpeg, png, bmp, <br> gif, svg или webp</div>
                <img @mouseenter="togglePhoto" @mouseleave="togglePhoto" class="photo-margin" src="../assets/question mark.svg">
              </div>
              <input 
                type="file" 
                id='upload' 
                accept="image/x-png,image/gif,image/jpeg,image/jpg,image/bmp,image/svg,image/webp"
                @change="uploadFile"
                v-on:click="uploadFileClick"
              >
              <label for='upload' class="input-file" :class="!review.errorPhotoViewPer == '' ? 'border-errors' : ''"><img src="../assets/upload.svg"></label>
            </div>
            <div class="flex mb-5 justify-center font-size-6 error-message-color-text namephoto">
              {{ review.photo_look }}
              {{ review.errorPhotoViewPer }}
            </div>
            <Checkbox
              id="consent"
              name="consent"
              type="checkbox"
              v-model:checked="v.checkBoxActive.$model"
              :error="v.checkBoxActive.$errors"
            />
            <button type="submit" class="form-button-click ml-12 cursor-pointer border-rd-20 border-0 text-color-white submain-background-color font-size-8">Зарегистрироваться</button>
            <p class="login text-color-white underline text-center mt-16 mb-24 mr-20 font-size-6">
              <router-link to="/authorisation">Уже есть аккаунт? Войти</router-link>
            </p>
            </form>
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

.custom-dropdown{
  margin: 20px 0px 20px 34px;
  background-color: #373737;
  width: 454px;
  height: 61px;
  border-radius: 30px; 
  background: url(../assets/dropmenu.svg) no-repeat right rgba(55, 55, 55, 1);
  background-position-x: calc(100% - 20px);
}
.custom-dropdown-placeholder{
  padding-top: 4px;
  padding-left: 32px;
  font-size: 32px;
  opacity: 50%;
}
.custom-dropdown-placeholder-city{
  padding-top: 6px;
  padding-left: 32px;
  font-size: 32px;
}
.custom-dropdown-list{
  position: relative;
  padding-right: 12px;
  z-index: 1;
  top:35%;
  left: 2%;
  width: 429px;
  height: 611px;
  background-color: #131313;
  border-radius: 30px;
  border: solid #F7F4A4;
  animation-name: dropdown-animation;
  animation-duration: 0.5s;
  overflow:scroll;
}
@keyframes dropdown-animation {
  from {
    height: 0px;
  }
  to {
    height: 611px;
  }
}
.custom-dropdown-list-item{
  margin: 30px 0 0 10px;
  background-color: #373737;
  width: 374px;
  height: 53px;
  border-radius: 30px; 
  animation-name: dropdown-list-item-animation;
  animation-duration: 0.5s;
}
.custom-dropdown-list-item span {
  color: #ffffff;
  font-size: 32px;
  padding: 7px 0 0 30px;
}
@keyframes dropdown-list-item-animation {
  from {
    /* opacity: 0%; */
    height: 0px;
  }
  to {
    /* opacity: 100%; */
    height: 53px;
  }
}
.custom-dropdown-list::-webkit-scrollbar {
  width: 10px;
}
.custom-dropdown-list::-webkit-scrollbar-button{
  display: none;
}
.custom-dropdown-list::-webkit-scrollbar-track {
  display: none;
}

.custom-dropdown-list::-webkit-scrollbar-thumb {
  background-color: #F7F4A4;
  border-radius: 20px;
}
.custom-dropdown-list::-webkit-scrollbar-corner{
  display: none;
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
  margin: 0 0 0 36px;
  padding: 20px 26px;
}
.form-button{
  margin: 0 0 0 50px;
}
.form-button-click{
  /* width: 85%; */
  margin-left: 6%;
  padding: 10px 76px 14px 78px;
  background: #373737;
  font-family: Inter,  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
}
#upload{
  display: none;
}
.border-errors{
    border: 2px solid #F47A7A;
}
.login a{
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
.error-message{
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
.photo-block{
  justify-content: space-between;
}
@media (max-width: 1440px) {
  .login{
    margin-right: 1rem;
  }
  .registration-logo{
    align-items: center;
  }
  .logo-shaman{
    width: 562px;
    height: 562px;
  }
  .registration{
    /* max-width: 500px; */
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 6%;
    margin-right: 6%;
  }
  .mandatory-label{
    margin-left: 12%;
    margin-bottom: 60px;
    max-width: 360px;
  }
  .photo-block-label{
    margin-right: 37%;
  }
  .registration-logo{
    margin-right: 6%;
    margin-top: 20px;
    margin-left: 6%;
  }
  .photo-margin {
    margin-right: 0;
  }
  .tooltip{
    left: 34px;
    top: 100%;
    z-index: 999;
    font-size: 32px;
    width: 80%;
    border-top-right-radius: 0;
    border-top-left-radius: 20px;
  }
  .container{
    display: flex;
    justify-content: center;
  }
  .registration-body{
    flex-direction: column;
  }
  .registration-form{
    margin-top: 20px;
  }
  .input-file{
    width: 74%;
    margin: 0 0 0 34px;
  }
  .form-button-click{
    margin-left: 6%;
    padding: 10px 80px 14px 80px;
  }
}
@media (max-width: 768px) {
  .registration-form{
    margin-top: 10px;
  }
  .arrow{
    width: 30px;
  }
  .registration-logo{
    margin-left: 0;
    margin-right: 0;
    margin-top: 50px;
  }
  .registration{
    margin-right: 6%;
    margin-left: 0;
  }
  .mandatory-label{
    max-width: 320px;
    margin-bottom: 40px;
    margin-left: 16%;
    font-size: 22px;
  }
  .mandatory-block{
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .registration-form{
    display: flex;
    flex-direction: column;
    /* align-items: center; */
  }
  .custom-dropdown{
    max-width: 312px;
    height: 46px;
    margin: 0px 0 20px 16px;
    background-size: 18px;
    background-position-x: calc(100% - 26px);
  }
  .custom-dropdown-placeholder{
    padding-top: 4px;
    font-size: 20px;
  }
  .custom-dropdown-placeholder-city {
    padding-top: 8px;
    font-size: 20px;
  }
  .custom-dropdown-list{
    max-width: 91%;
    left: 0;
    overflow-x: hidden;
    padding-right: 24px;
  }
  .custom-dropdown-list-item{
    max-width: 100%;
    height: 44px;
    display: flex;
    margin: 20px 0 0 8%;
  }
  .custom-dropdown-list::-webkit-scrollbar-thumb {
    display: none;
  }
  .custom-dropdown-list-item span{
    font-size: 16px;
    padding: 10px 0 0 30px;
  }
  .gender-label{
    font-size: 16px;
    margin-bottom: 16px;
    margin-right: 2rem;
  }
  .gender-body{
    margin-left: 0;
    margin-bottom: 0;
  }
  .custom-radio+label[data-v-ce3ae30b]::before {
    height: 26px;
    width: 26px;
  }
  .star-photo{
    width: 8px;
    position: absolute;
    left: -1%;
    top: 40%;
  }
  .photo-label{
    font-size: 16px;
  }
  .photo-block{
    max-width: 300px;
  }
  .photo-margin{
    position: absolute;
    right: -21%;
    width: 26px;
  }
  .input-file{
    margin: 0 30px 0 16px;
    width: 72%;
    padding: 24px 32px;
    height: 53px;
  }
  .error-message{
      font-size: 16px;
      margin-top: 0;
      margin-bottom: 20px;
  }
  .form-button-click{
    max-width: 318px;
    font-size: 16px;
    padding: 10px 56px 14px 56px;
    margin-left: 4%;
  }
  .login{
    font-size: 14px;
    margin-right: 0;
    /* margin-left: 14%; */
  }
  .gender-body{
    margin-left: 8%;
  }
  .namephoto{
    font-size: 16px;
    margin-right: 36%;
  }
  .tooltip-photo{
    width: 116% !important;
    top: 140%;
  }

  .logo-shaman{
    display: none;
  }
  .title-shaman{
    font-size: 76px;
  }
  .tooltip{
    left: -2%;
    font-size: 16px;
    width: 100%;
  }
}
</style>