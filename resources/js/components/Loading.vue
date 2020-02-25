<template>
  <div class="wrapper ">
    <div class="loading">
      <span></span><span></span><span></span><span></span><span></span>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
.wrapper {
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(255, 121, 121, 1);
}

.loading span {
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  vertical-align: middle;
  margin: 0 6px;
  animation: scale 1s infinite;
}

.loading span:nth-child(1) {
  background-color: #e056fd;
  animation-delay: 0.1s;
}

.loading span:nth-child(2) {
  background-color: #eb4d4b;
  animation-delay: 0.2s;
}

.loading span:nth-child(3) {
  background-color: #686de0;
  animation-delay: 0.3s;
}

.loading span:nth-child(4) {
  background-color: #badc58;
  animation-delay: 0.4s;
}

.loading span:nth-child(5) {
  background-color: #f9ca24;
  animation-delay: 0.5s;
}

@keyframes scale {
  0%,
  100% {
    transform: scale(1);
  }
  50% {
    transform: scale(2);
    opacity: 0.2;
  }
}
</style>