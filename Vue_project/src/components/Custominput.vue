<script setup>
import { ref, reactive } from 'vue'
import { vMaska } from "maska"

const emits = defineEmits(['update:value'])
const props = defineProps({
    name: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    value: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        required: true
    },
    tooltip: {
        type: Boolean,
        default: false
    },
    requiredStar: {
        type: Boolean,
        default: false
    },
    textTooltip:{
        type: Boolean,
        default: ''
    },
    error: {
        type: Array,
        required: false
    },
    tooltiptext: {
        type: String,
        default: ''
    },
    mask: {
        type: String,
        default: ''
    }
})

const isShow = ref(false)
const custom_type = ref(props.type)

const updateValue = (e) => {
    emits('update:value', e.target.value);
}

const options = reactive({
    mask: ref(props.mask),
    eager: true
})
</script>

<template>
    <div class="flex mb-5 tooltip-group relative input-block">
        <img v-if="requiredStar == true" src="../assets/star.svg" class="star"/>
        <div class="relative">
            <input
                :id="name"
                :name="name"
                :type="custom_type"
                :value="value"
                :placeholder="placeholder" 
                @input="updateValue"
                class="input border-rd-10 text-color-white input-padding input-margin submain-background-color font-size-8 border-0"
                :class="error.length > 0 ? 'border-errors' : ''"
                v-maska:[options]
            >
            <img v-if="(custom_type == 'password') && (type == 'password')" @click="custom_type = 'text'" class='input-icon absolute input-icon-top input-icon-right' src="../assets/eye.svg"/>
            <img v-if="(custom_type == 'text') && (type == 'password')" @click="custom_type = 'password'" class='input-icon absolute input-icon-top input-icon-right' src="../assets/passwordhide.svg"/>
        </div>
        <img @mouseenter="isShow = !isShow" @mouseleave="isShow = !isShow" v-if="tooltip == true" src="../assets/question mark.svg" class="answer"/>
        <div v-show="isShow" class="tooltip">
            <span v-html="tooltiptext"></span>
        </div>
    </div>
    <TransitionGroup>
        <div v-for="element of error" :key="element.$uid" class="mb-5 flex mt-5 font-size-8 error-message error-message-color-text">
            {{ element.$message }}
        </div>
    </TransitionGroup>
</template>

<style scoped>
.input{
    background: #373737;
    /* outline: 4px solid #373737;
    outline-offset: -1px;
    color: #FFFFFF; */
}
.star{
    width: 16px;
}
.error-message{
    margin-left: 52px;
}
.border-errors{
    border: 2px solid #F47A7A;
}
/* input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active  {
    box-shadow: 40px 40px 40px 100px #373737 inset !important;
    color: #FFFFFF !important;
} */
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

@media (max-width: 1440px) {
    .tooltip{
        left: 34px;
        top: 100%;
        z-index: 999;
        font-size: 32px;
        width: 80%;
        border-top-right-radius: 0;
        border-top-left-radius: 20px;
    }
}
@media (max-width: 768px) {
    .star{
    width: 8px;
}
    .tooltip{
        left: -2%;
        font-size: 16px;
        width: 100%;
    }
    .input-block{
        max-width: 350px;
    }
    .input-icon {
        width: 24px;
    }
    .input-icon-right {
        right: 36px;
    }
    .input-icon-top {
        top: 16px;
    }
    .answer{
        width: 26px;
    }
    .error-message{
        font-size: 16px;
        margin-top: 0;
        margin-bottom: 20px;
    }
    .input{
        font-size: 20px;
        margin: 0 10px 0 8px;
    }
}
</style>