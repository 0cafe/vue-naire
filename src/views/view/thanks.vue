<template>
  <div class="container">
      <div>感谢参与调查  ^_^</div>
      <div>
        <router-link to='/'>
          去后台
        </router-link>
      </div>
  </div>
</template>

<script>

</script>

<style scoped="scoped">
  .container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .container:nth-child(1){
    font-size: 32px;
    font-weight: bold;
  }
  a{
    list-style: none;
    text-decoration: none;
    font-size: 16px;
    color: black;
    font-weight:600;
  }
  a:hover{
    color: gray;
  }
</style>
