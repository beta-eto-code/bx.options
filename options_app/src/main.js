import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui';
import Vue2Editor from "vue2-editor";
import locale from 'element-ui/lib/locale/lang/ru-RU'
import 'element-ui/lib/theme-chalk/index.css';
import './assets/bitrix_admin.css';


Vue.config.productionTip = false
Vue.use(ElementUI, {locale});
Vue.use(ElementUI);
Vue.use(Vue2Editor);
Vue.component("ComponentBuilder", () => import("./component-builder"));

const renderApp = (data) => {
    new Vue({
        render: h => h(App, {props: {
            optionsConfig: data,
            }}),
    }).$mount('#app')
}
document.addEventListener('DOMContentLoaded', () =>  {
    if (process.env.NODE_ENV === "development") {
        fetch(process.env.DEV_FETCH_URL)
            .then((response) => response.json())
            .then((json) => renderApp(json));
    } else {
        renderApp(window.optionFormData);
    }
});
