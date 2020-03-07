<template>
  <div id="app" class="container">
        <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: 'App',
  components: {

  },
}
</script>

<style>
body{
  margin: 0;
  padding: 0;
  width: 100%;
}
#app{
  margin: 0;
  padding: 0;
  font-size: 14px;
  width: 100%;
}
</style>
