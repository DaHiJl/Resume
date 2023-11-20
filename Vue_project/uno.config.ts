import { defineConfig } from 'unocss'

export default defineConfig({
    rules: [
        ['main-background-color', {background: '#131313'}],
        ['submain-background-color', {background: '#565656'}],
        ['error-message-color-text', {color: '#F7F4A4'}],
        ['text-color-white', {color: '#FFFFFF'}],
        ['input-padding', {padding: '12px 32px'}],
        ['input-margin', {margin: '0 18px'}],
        ['input-icon-top', {top: '18px'}],
        ['input-icon-right', {right: '30px'}],
    ],
})