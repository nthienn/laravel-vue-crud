import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import { createPinia } from 'pinia';
import router from './router/index.js';
import { Button, message, Drawer, List, Menu, Card, Table, Avatar, Select, Input, Checkbox } from 'ant-design-vue';
import axios from 'axios';
window.axios = axios;

import 'ant-design-vue/dist/reset.css';
import 'bootstrap/dist/css/bootstrap-grid.min.css';
import 'bootstrap/dist/css/bootstrap-utilities.min.css';

const app = createApp(App)
app.use(createPinia());
app.use(router)
app.use(Button)
app.use(Drawer)
app.use(List)
app.use(Menu)
app.use(Card)
app.use(Table)
app.use(Avatar)
app.use(Select)
app.use(Input)
app.use(Checkbox)
app.mount("#app")

app.config.globalProperties.$message = message;