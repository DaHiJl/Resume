<script setup>
const emits = defineEmits(['update:checked'])
const props = defineProps({
    id: {
        type: String,
        default: ''
    },
    name: {
        type: String,
        default: ''
    },
    checked:{
        type: Boolean,
        default: false
    },
    error: {
        type: Array,
        required: false
    }
})
const handleClick = (event) => {
    emits('update:checked', event.target.checked)
}
</script>

<template>
    <div class="mb-5 checkbox-body checkbox-width">
        <img src="../assets/star.svg" />
        <input 
        :id="name"
        :name="name"
        type="checkbox" 
        :checked="checked"
        class="custom-checkbox" 
        @input="handleClick($event)"
        >
        <label for="consent" class="checkbox-label flex font-size-8 text-color-white widthchecbox" >Я даю свое согласие на обработку персональных данных</label>
    </div>
    <TransitionGroup>
        <div v-for="element of error" :key="element.$uid" class="mb-5 flex mt-5 font-size-8 errorMessage error-message-color-text">
            {{ element.$message }}
        </div>
    </TransitionGroup>
</template>

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
.checkbox-width{
    display: flex;
    width: 630px;
}
</style>