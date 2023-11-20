<template>
  <div class="main-page ma overflow-hidden pt-10 pb-10 submain-background-color">
    <div class="container ma b-rd-10 main-background-color">
      <div class="registration-body flex justify-center">
        <div class="registration-logo flex justify-center flex-col mr-10">
          <img class="logo-shaman" src="./assets/logoShaman.svg" />
          <div class="title-shaman text-center font-size-30 text-color-white">
            SHAMAN
          </div>
        </div>
        <!-- @submit.prevent="RegisterUser" -->
        <!-- novalidate @submit.prevent="onSubmit" -->
        <Form class="registration-form mt-20" novalidate @submit.prevent="onSubmit">
          <!-- <Field name="email" type="email" :rules="validateEmail" v-slot="{ field, errorMessage, meta }">
            <input v-bind="field" :class="errorMessage ? 'borderErrors' : ''" />
            <span v-if="errorMessage">⛔️ {{ errorMessage }}</span>
            <span v-if="meta.valid && meta.touched">✅ Field is valid</span>
          </Field> -->
          <div class="form-group flex mb-5 justify-center font-size-6 error-message-color-text">
            <label>Поля, отмеченные * являются обязательными</label>
          </div>
          <div class="form-group flex mb-5">
            <img src="./assets/star.svg" />
            <!-- <Field name="login" id="login" class="input border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" type="text" placeholder="Логин: " v-model.trim="login" :rules="validateLogin"/> -->
            <!-- <input id="login" class="input border-rd-10 border-0 text-color-white input-padding input-margin submain-background-color font-size-8" type="text" placeholder="Логин: " v-model.trim="login" :rules="validateLogin" /> -->
            <Field name="login" type="text" :rules="validateLogin" v-slot="{ field, errorMessage, meta }">
              <input v-bind="field" class="input border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8 border-0" :class="errorMessage ? 'borderErrors' : ''" v-model.trim="login" placeholder="Логин "/>
            </Field>
          </div>
          <div class="form-group flex mb-5 font-size-8 errorMessage error-message-color-text">
            <ErrorMessage name="login"/>
          </div>
          <div class="form-group flex mb-5 tooltip-group relative">
            <img src="./assets/star.svg" />
            <div class="input-wrapper relative">
              <!-- <Field name="password" rules="requiredPass" />
              <Field name="confirmation" rules="requiredPass|confirmed:password|passwordValidate" />
              <ErrorMessage name="confirmation"/> -->
              <Field name="password" :type="passwordFieldType" rules="requiredPass|passwordValidate" v-slot="{ field, errorMessage, meta }">
                <input v-bind="field" class="input border-0 border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" :class="errorMessage ? 'borderErrors' : ''" v-model.trim="password" :type="passwordFieldType" placeholder="Пароль "/>
              </Field>
              <!-- <input id="password" class="input border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" placeholder="Пароль: " :type="passwordFieldType" v-model.trim="password" > -->
              <img class='input-icon absolute input-icon-top input-icon-right' src="./assets/eye.svg" v-show="isShowPassword" type="password" @click="switchVisibility"/>
              <img class='input-icon absolute input-icon-top input-icon-right' src="./assets/passwordhide.svg" v-show="!isShowPassword" type="password" @click="switchVisibility" />
            </div>
            <div v-show="isShown" class="tooltip tooltip-bottom">Пароль должен состоять из <br> латинских символов. <br> Должен содержать знаки и <br> заглавные буквы</div>
            <img  @mouseenter="toggle" @mouseleave="toggle" src="./assets/question mark.svg" />
          </div>
          <div class="form-group flex mb-5 font-size-8 errorMessage error-message-color-text">
            <ErrorMessage name="password"/>
          </div>
          <div class="form-group flex mb-5">
            <img src="./assets/star.svg" />
            <div class="input-wrapper relative">
              <Field name="passwordConfirm" :type="passwordFieldTypeConfirm" rules="passwordValidate|confirmed:password" v-slot="{ field, errorMessage, meta }">
                <input v-bind="field" class="input border-0 border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" :class="errorMessage ? 'borderErrors' : ''" v-model.trim="passwordConfirm" :type="passwordFieldTypeConfirm" placeholder="Повторите пароль  "/>
              </Field>
              <!-- <input id="passwordConfirm" class="input border-rd-10 border-0 text-color-white input-padding input-margin submain-background-color font-size-8" placeholder="Повторите пароль: " :type="passwordFieldTypeConfirm" v-model.trim="passwordConfirm"> -->
              <img class='input-icon absolute input-icon-top input-icon-right' src="./assets/eye.svg" v-show="isShowPasswordConfirm" type="password" @click="switchVisibilityConfirm"/>
              <img class='input-icon absolute input-icon-top input-icon-right' src="./assets/passwordhide.svg" v-show="!isShowPasswordConfirm" type="password" @click="switchVisibilityConfirm" />
            </div>
          </div>
          <div class="form-group flex mb-5 font-size-8 errorMessage error-message-color-text">
            <ErrorMessage name="passwordConfirm"/>
          </div>
          <div class="form-group flex mb-5 tooltip-group relative">
            <img src="./assets/star.svg" />
            <div class="input-wrapper relative">
              <Field name="phone" type="phone" rules="phoneValidate" v-slot="{ field, errorMessage, meta }">
                <input v-bind="field" class="input border-0 border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" :class="errorMessage ? 'borderErrors' : ''" v-model.trim="phone" type="phone" placeholder="Телефон  "/>
              </Field>
              <!-- <input id="phone" class="input border-rd-10 border-0 text-color-white input-padding input-margin submain-background-color font-size-8" type="phone" placeholder="Телефон: " v-model.trim="phone"> -->
            </div>
            <div v-show="isShownPhone" class="tooltip">Номер должен вводиться с <br> кодом страны</div>
            <img @mouseenter="togglePhone" @mouseleave="togglePhone" src="./assets/question mark.svg" />
          </div>
          <div class="form-group flex mb-5 font-size-8 errorMessage error-message-color-text">
            <ErrorMessage name="phone"/>
          </div>
          <div class="form-group flex mb-5">
            <div class="input-wrapper relative city w-full mb-5">
              <select name="" id="city" class="input-city" v-model="city">
                <option selected disabled value="">Город: </option>
                <option v-for="{value, label} in citys" :key="value" :value="value.value">
                {{ label }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group flex flex-col mb-5">
            <div class="mb-5">
              <img src="./assets/star.svg" />
              <Field name="email" type="email" rules="emailValidate" v-slot="{ field, errorMessage, meta }">
                <input v-bind="field" class="input border-0 border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8" :class="errorMessage ? 'borderErrors' : ''" v-model.trim="email" type="email" placeholder="Почта  "/>
              </Field>
              <!-- <Field name="email" id="email" class="input border-rd-10 border-0 text-color-white input-padding input-margin submain-background-color font-size-8" type="email" placeholder="Почта" v-model.trim="email" rules="emailValidate" /> -->
            </div>
            <div class="form-group flex mb-5 font-size-8 errorMessage error-message-color-text">
              <ErrorMessage name="email"/>
            </div>
            <!-- <input id="email" class="input border-rd-10 border-0 text-color-white input-padding input-margin submain-background-color font-size-8" type="email" placeholder="Почта" v-model.trim="email" :rules="validateEmail"> -->
          </div>
          <div class="form-group flex mb-5 gender-body flex-col ml-13">
            <label class="gender-label font-size-8 text-color-white">Пол: </label>
            <div class="gender-block flex grid-items-center">
              <input class="custom-radio" type="radio" name="gender" id="gender-male" value="male" v-model.trim="gender">
              <label for="gender-male" class="gender-label font-size-8 text-color-white sex mr-8">Муж</label>
              <input class="custom-radio" type="radio" name="gender" id="gender-femile" value="famel" v-model.trim="gender">
              <label for="gender-femile" class="gender-label font-size-8 text-color-white sex mr-8">Жен</label>
            </div>
          </div>
          <div class="form-group flex mb-5 photo-body flex-col">
            <div class="photo-block flex justify-between relative  mb-5">
              <div>
                <img src="./assets/star.svg" />
                <label class="photo-label font-size-8 text-color-white ml-8">Фото паспорта: </label>
              </div>
              <div v-show="isShownPhoto" class="tooltip tooltip-top">Прикрепите фото первой <br> страницы паспорта.Фото <br> должно быть в форматах <br> jpg, jpeg, png, bmp, <br> gif, svg или webp</div>
              <img @mouseenter="togglePhoto" @mouseleave="togglePhoto" class="photo-margin" src="./assets/question mark.svg">
            </div>
            <Field name="upload" type="file" rules="requiredPhoto" v-slot="{ field, errorMessage, meta }">
                <!-- <input v-bind="field" type="file" id='upload' accept="image/x-png,image/gif,image/jpeg"/> -->
                <input v-bind="field" type="file" id='upload' accept="image/x-png,image/gif,image/jpeg,image/jpg,image/bmp,image/svg,image/webp" />
                <label for='upload'  class="input-file" :class="meta.dirty ? '' : 'borderErrors'"><img src="./assets/upload.svg"></label>
            </Field>
            <!-- <input type="file" id='upload' /> -->
            <!-- <label for='upload' class="input-file"><img src="./assets/upload.svg"></label> -->
            <div class="form-group flex mt-5 font-size-8 errorMessage error-message-color-text">
              <ErrorMessage name="upload"/>
            </div>
          </div>
          <div class="form-group flex mb-5 checkbox-body">
            <img src="./assets/star.svg" />
            <Field name="consent" type="checkbox" rules="requiredCheckBox" id="consent" v-slot="{ field, errorMessage, meta }">
              <input v-bind="field" type="checkbox" class="custom-checkbox" id="consent" v-model="consent">
              <label for="consent" class="checkbox-label font-size-8 text-color-white " >Я даю свое согласие на <br> обработку персональных <br> данных</label>
            </Field>
            <!-- <input type="checkbox" class="custom-checkbox" id="consent" name="consent" v-model="consent">
            <label for="consent" class="checkbox-label font-size-6 text-color-white">Я даю свое согласие на обработку <br> персональных данных</label> -->
          </div>
          <div class="form-group flex mt-5 font-size-8 errorMessage mb-5 error-message-color-text">
              <ErrorMessage name="consent"/>
            </div>
          <div class="form-button text-center">
              <button type="submit" class="form-button-click cursor-pointer border-rd-20 border-0 p-3 text-color-white submain-background-color font-size-8">Зарегистрироваться</button>
          </div>
          <p class="loginIn text-color-white underline text-center mt-16 mb-24 font-size-6">
            <router-link to="#">Уже есть аккаунт? Войти</router-link>
          </p>
        </Form>
      </div>
    </div>
  </div>
</template>

<!-- <script lang="ts"> -->
<script lang="ts">
import { Field, Form, ErrorMessage } from 'vee-validate';
import { defineRule } from 'vee-validate';
import { required, email, min } from '@vee-validate/rules';
import { configure } from 'vee-validate';

configure({
  validateOnBlur: true, // controls if `blur` events should trigger validation with `handleChange` handler
  validateOnChange: true, // controls if `change` events should trigger validation with `handleChange` handler
  validateOnInput: false, // controls if `input` events should trigger validation with `handleChange` handler
  validateOnModelUpdate: true, // controls if `update:modelValue` events should trigger validation with `handleChange` handler
});

defineRule('confirmed', (value, [target], ctx) => {
  if (value === ctx.form[target]) {
    return true;
  }
  return 'Пароли не совпадают!';
});

defineRule('requiredPass', value => {
  if (!value || !value.length) {
    return 'Пароль не заполнен!';
  }
  return true;
});

defineRule('passwordValidate', value => {
  if (!/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/g.test(value)) {
    return 'Пароль введен не корректно!';
  }
  return true;
});

defineRule('phoneValidate', value => {
  if (!value || !value.length) {
    return 'Телефон не заполнен!';
  }
  if (!/^([+]?[0-9\s-\(\)]{10,25})*$/i.test(value)) {
    return 'Телефон введен не корректно!';
  }
  return true;
});

defineRule('emailValidate', value => {
  if (!value || !value.length) {
    return 'Почта не введена!';
  }
  const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
  if (!regex.test(value)) {
    return 'Почта введена не корректно!';
  }
  return true;
});

defineRule('requiredPhoto', value => {
  if (!value) {
    return 'Фото паспорта не добавлено!';
  }
  return true;
});

defineRule('requiredCheckBox', value => {
    if (value) {
      return true;
    }
    return 'Согласие не дано!';
});


  export default{
    data() {
        return {
          login: "",
          password: "",
          passwordConfirm: "",
          phone: "",
          city: '',
          citys: [
            { value: 'Moscov', label: "Москва"},
            { value: 'Volgograd', label: "Волгоград"},
            { value: 'Omsk', label: "Омск"},
            { value: 'Ekaterinburg', label: "Екатеринбург"},
            { value: 'Tomsk', label: "Томск"},
          ],
          email: "",
          gender: "",
          consent: false,
          errors:[],

          errorlogin: '',

          passwordFieldType: "password",
          passwordFieldTypeConfirm: "password",

          isShown: false,
          isShownPhone: false,
          isShownPhoto: false,
          isShowPassword: true,
          isShowPasswordConfirm: true,

        };
    },
    components: {
      Form,
      Field,
      ErrorMessage,
    },
    methods: {
      RegisterUser(){
        console.log("Вы успешно зарегистрировались!");
      },
      toggle() {
        this.isShown = !this.isShown;
      },
      togglePhone() {
        this.isShownPhone = !this.isShownPhone;
      },
      togglePhoto() {
        this.isShownPhoto = !this.isShownPhoto;
      },
      switchVisibility() {
        this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
        this.isShowPassword  = !this.isShowPassword;
      },
      switchVisibilityConfirm() {
        this.passwordFieldTypeConfirm = this.passwordFieldTypeConfirm === "password" ? "text" : "password";
        this.isShowPasswordConfirm  = !this.isShowPasswordConfirm;
      },

      onSubmit() {
        // console.log('Submitted');
        this.$router.push('http://localhost:5173/public/test.html');
      },

      validateLogin(value){
        if (!value) {
          return 'Логин не введен!';
        }
        if (value.length < 8) {
          return 'Логин менее 8-ми символов!';
        }
        return true;
      },
    },
};
</script>

<style scoped>
/* Настройка кастомного чекбокса */
.custom-checkbox {
  position: absolute;
  z-index: -1;
  opacity: 0;
}
.custom-checkbox+label {
  display: inline-flex;
  align-items: center;
  user-select: none;
}
.custom-checkbox+label::before {
  content: '';
  display: inline-block;
  margin-left: 32px;
  margin-right: 32px;
  width: 36px;
  height: 36px;
  flex-shrink: 0;
  flex-grow: 0;
  border: 1px solid #373737;
  border-radius: 0.25em;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: 50% 50%;
  background: #373737;
}
.custom-checkbox:checked+label::before {
  border-color: #F7F4A4;
  background-color: #F7F4A4;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2ffff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}
/* стили при наведении курсора на checkbox */
.custom-checkbox:not(:disabled):not(:checked)+label:hover::before {
  border-color: #F7F4A4;
}
/* стили для активного состояния чекбокса (при нажатии на него) */
.custom-checkbox:not(:disabled):active+label::before {
  background-color: #F7F4A4;
  border-color: #F7F4A4;
}
/* стили для чекбокса, находящегося в фокусе */
.custom-checkbox:focus+label::before {
  box-shadow: 0 0 0 0.2rem rgba(239, 255, 57, 0.25);
}
/* стили для чекбокса, находящегося в фокусе и не находящегося в состоянии checked */
.custom-checkbox:focus:not(:checked)+label::before {
  border-color: #80bdff;
}
/* стили для чекбокса, находящегося в состоянии disabled */
.custom-checkbox:disabled+label::before {
  background-color: #e9ecef;
}

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
/* Кастомный тултип */
.tooltip{
  padding: 10px;
  border-top-right-radius: 20px;
  border-top-left-radius: 20px;
  border-bottom-right-radius: 20px;
  border: 2px solid #F7F4A4;
  position: absolute;
  top: -70px;
  right: -65%;
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
  width: 86%;
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
  height: 140px;
  width: 65%;
  border-radius: 30px;
  margin: auto;
  padding: 20px 40px;
}
.form-button-click{
  width: 85%;
  background: #373737;
  font-family: Inter,  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
}
.form-group:nth-child(10){
  margin-left: 20px;
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
  .input-city{
    width: 84%;
  }
  .photo-margin {
    margin-right: 10px;
  }
  .tooltip{
    right: 0;
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
    right: -2%;
  }
}
</style>