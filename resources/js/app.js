require("./bootstrap");
import Vue from "vue";
import VueAMap from "vue-amap";

Vue.use(VueAMap);

Vue.component("Weather", require("./components/Weather.vue").default);

new Vue().$mount("#app");
