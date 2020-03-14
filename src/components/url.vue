<template>
  <el-dialog title="分享问卷" :visible.sync="centerDialogVisible" width="35%" center @open="open" @close="close">
    <div class="container">
      <div class="url">
        链接 : <a>{{url}}</a>
      </div>
      <div id="qrcode" v-loading="loading">

      </div>
      <div class="tip">
        如二维码失效,请使用链接
      </div>
    </div>
  </el-dialog>
  <!-- <div class="container">

    <i class="el-icon-close" @click="close"></i>
    <div class="url">
      链接 : <a>{{url}}</a>
    </div>
    <div id="qrcode">

    </div>
    <div class="tip">
      如二维码失效,请使用链接
    </div>
  </div> -->
</template>

<script>
  import {
    get
  } from '../axios/api.js'
  import QRCode from 'qrcodejs2'
  // cnpm install --save qrcodejs2 引入
  export default {
    props: ['url'],
    data() {
      return {
        centerDialogVisible: true,
        loading: true
      }
    },
    methods: {
      getQrcode() {
        // let data = {
        //   url: this.url
        // }
        // get('qrcode', data).then(res => {
        //   console.log(res)
        // })
        let qrcode = new QRCode('qrcode', {
          width: 200,
          height: 200,
          text: this.url, // 二维码地址
          colorDark: "#000",
          colorLight: "#fff",
          correctLevel: QRCode.CorrectLevel.H //容错级别  L M Q H
        })
        this.loading = false
      },
      open(res) {
        this.getQrcode()
      },
      close() {
        this.centerDialogVisible = false
        this.$emit('close')
      },
    },
    mounted() {
      // 对于dom的操作 必须等到mounted生命周期 div节点生成以后
      this.loading = true
      setTimeout(() => {
        this.getQrcode()
      }, 1000)
    }
  }
</script>

<style scoped="scoped" lang="scss">
  .container {
    z-index: 999;
    // position: absolute;
    // top: 50px;
    // left: 40%;
    background-color: #FFFFFF;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    height: 100%;
    width: 100%;
    // border: 1px solid #eaeaea;
    // box-shadow: 0 0 25px #cac6c6;

    .el-icon-close {
      font-size: 24px;
      margin-left: 95%;
    }

    .url {
      font-size: 24px;
    }

    #qrcode {
      display: inline-block;
      margin: 20px 0 20px 0;
      img {
        width: 132px;
        height: 132px;
        background-color: #fff; //设置白色背景色
        padding: 6px; // 利用padding的特性，挤出白边
      }
    }
  }
</style>
