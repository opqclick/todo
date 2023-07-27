/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

import axios from 'axios'
import VueAxios from 'vue-axios'

import Toaster from '@meforma/vue-toaster';

const app = createApp({});

app.use(Toaster)

app.use(VueAxios, axios)

import WelcomeComponent from "./components/WelcomeComponent.vue";
import TodoComponent from "./components/TodoComponent.vue";

app.component('welcome-component', WelcomeComponent);
app.component('todo-component', TodoComponent);

app.mount('#app');


