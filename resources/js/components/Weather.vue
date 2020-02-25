<template>
  <div class="text-white mb-8">
    <div id="allmap" class="hidden"></div>
    <div class="places-input text-gray-600">
      <input
        id="suggestId"
        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-norma"
        type="text"
        placeholder="请输入位置信息"
        @keyup.enter="handleSearch"
      />

      <div
        ref="searchResultPanel"
        style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"
      ></div>
    </div>

    <div
      class="weather-container font-sans md:w-128 max-w-lg rounded-lg overflow-hidden bg-purple-900 shadow-lg mt-4"
    >
      <div class="current-weather flex justify-between items-center px-3 py-4">
        <div class="flex flex-row items-center">
          <div class="text-4xl font-semibold">
            {{ currently.temperature }}°C
          </div>

          <div class="mx-5">
            <div>{{ currently.time | transToWeekDay }}</div>
            <div>{{ address }}</div>
          </div>
        </div>

        <div class="flex justify-between items-center">
          <div class="font-semibold">{{ currently.summary }}</div>
          <canvas
            width="48"
            height="48"
            id="currently-icon"
            class="ml-3"
          ></canvas>
        </div>
      </div>
      <div
        class="future-weather text-sm bg-purple-700 px-6 py-8 overflow-hidden"
      >
        <div
          v-for="(day, index) in futureDailyFiveInfo"
          :key="day.time"
          class="flex items-center"
          :class="{ 'mt-6': index > 0 }"
        >
          <div class="w-1/6 text-lg text-gray-200">
            {{ day.time | transToWeekDay }}
          </div>

          <div class="w-4/6 px-4 flex items-center">
            <canvas
              width="24"
              height="24"
              :id="`future-icon-${index}`"
            ></canvas>
            <div class="ml-3">{{ day.summary }}</div>
          </div>
          <div class="w-1/6 text-right">
            <div>{{ Math.round(day.temperatureMin) }}°C</div>
            <div>{{ Math.round(day.temperatureMax) }}°C</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import skycons from "skycons";
const SkyconsClass = skycons(window);

export default {
  data() {
    return {
      currently: {
        time: null,
        temperature: "--",
        summary: "--"
      },
      address: "--",
      futureDailyFiveInfo: []
    };
  },

  mounted() {
    this.initMap();
    this.sc = new SkyconsClass({ color: "white", resizeClear: true });
  },

  filters: {
    transToWeekDay(time) {
      if (!time) return "--";
      const newDate = new Date(time * 1000);
      const days = ["周日", "周一", "周二", "周三", "周四", "周五", "周六"];
      return days[newDate.getDay()];
    }
  },

  methods: {
    initMap() {
      const self = this;
      self.map = new BMap.Map("allmap");
      self.map.centerAndZoom("深圳", 10);

      const geolocation = new BMap.Geolocation();
      geolocation.getCurrentPosition(
        function(r) {
          if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            const mk = new BMap.Marker(r.point);
            const {
              address: { city },
              point: { lat, lng }
            } = r;
            self.address = city;
            self.map.addOverlay(mk);
            self.map.panTo(r.point);
            self.fetchWeatherInfo(lat, lng);
          } else {
            alert("failed" + this.getStatus());
          }
        },
        { enableHighAccuracy: true }
      );
    },

    handleSearch(e) {
      const city = e.target.value;
      const self = this;
      if (city != "") {
        self.map.clearOverlays();
        const local = new BMap.LocalSearch(this.map, {
          onSearchComplete: function() {
            const {
              address,
              point: { lat, lng }
            } = local.getResults().getPoi(0);
            self.address = address;
            self.fetchWeatherInfo(lat, lng);
          }
        });
        local.search(city);
      }
    },

    async fetchWeatherInfo(lat, lng) {
      try {
        const {
          data: {
            currently: { temperature, summary, time, icon },
            daily: { data }
          }
        } = await axios.get(`/api/weather?lat=${lat}&lng=${lng}`);

        this.currently.temperature = temperature;
        this.currently.summary = summary;
        this.currently.time = time;
        this.futureDailyFiveInfo = data.slice(1, 6);

        this.$nextTick(() => {
          this.sc.add("currently-icon", icon);
          data.forEach((item, index) => {
            this.sc.add(`future-icon-${index}`, item.icon);
          });
          this.sc.play();
        });
      } catch (e) {
        console.error(e);
      }
    }
  },

  beforeDestroy() {
    this.sc.pause();
    this.sc = null;
  }
};
</script>

<style>
</style>