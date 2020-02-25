require("./bootstrap");
import Vue from "vue";

Vue.component("Weather", require("./components/Weather.vue").default);

new Vue().$mount("#app");
