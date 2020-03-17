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
  //app全部渲染出来后隐藏加载
  mounted() {
    document.getElementById('loader').style.display = 'none'
  }
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
