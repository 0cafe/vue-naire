<template>
  <div class="container" v-loading="loading" v-if="!filled && !over">
    <div class="title">
      {{dataArr.n_title}}
    </div>

    <div class="main">
      <div v-for="(item,i) in questions" class="item">
        <p><span style="color: red;" v-if="item.q_isrequire == 1">*</span>{{i+1}}.{{item.q_content}}
          <span style="color: f6f6f6!important;">({{item.q_type}})</span></p>

        <el-radio-group v-model="selectData[i]" v-if="item.q_type == '单选'" ref="radioM">
          <div v-for="(opt,index) in item.option" class="opt">
            <el-radio :label="opt" size="medium">{{opt.o_value}}</el-radio>
          </div>
        </el-radio-group>

        <el-checkbox-group v-model="checkData" v-if="item.q_type == '多选'" :ref="'checkbox'+item._id">
          <div v-for="(opt,index) in item.option">
            <el-checkbox :label="opt">{{opt.o_value}}</el-checkbox>
          </div>
        </el-checkbox-group>

      </div>
    </div>
    <el-button type="primary" round @click="submit()">提交</el-button>
  </div>
  <thanks v-else :over="over"></thanks>
</template>

<script>
  import {
    post,
    get
  } from '@/axios/api.js'
  import {
    errorToast,
    successToast
  } from '@/common/toast'
  import thanks from './thanks.vue'
  export default {
    components: {
      thanks
    },
    data() {
      return {
        over: false,
        filled: false,
        n_id: '',
        dataArr: '',
        questions: '',
        options: [],
        selectData: [],
        answer: [],
        checkData: [], //选中的多选题答案
        loading: true,
        dData: [], //多选题的q_id
        single: [], //单选
        multiple: [] //多选
      }
    },
    methods: {
      // 获取
      async getQuestion(id) {
        await get('/naire/' + id)
          .then(res => {
            console.log(res)
            if (!res) {
              errorToast('没有找到此问卷')
              this.$router.push('/*')
              return
            }
            if (res.n_status == 0) {
              errorToast('该问卷已截止')
              this.over = true
              return
            }
            this.dataArr = res
            this.questions = res.questions
            this.loading = false
          })
      },

      // 提交
      async submit() {
        let single = this.selectData.filter(d => d) // 过滤数组中的empty项
        let checkData = this.checkData.filter(d => d)
        let checkId = [];
        console.log(this.checkData)
        this.checkData.forEach((item, i) => {
          checkId.push(item.q_id)
        })
        let flag = true
        this.dData.forEach((item, i) => {
          if (checkId.indexOf(item) === -1) {
            flag = false
          }
        })
        console.log(flag)
        if (single.length < this.single.length || !flag) {
          return errorToast('请完整填写再提交')
        }

        let arr = [];
        arr = single.concat(checkData)
        arr.forEach((item, i) => {
          item.o_id = item.id
          item.n_id = this.n_id
          delete item['id']
        })
        // if (arr.length < this.questions.length) {
        //   return errorToast('请完整填写再提交')
        // }
        console.log(arr)
        await post('/naire/answer', arr)
          .then((res) => {
            if (!res.error_code === 0) {
              successToast('内部错误')
            }
            successToast('提交成功')
            this.filled = true
            // this.$router.push('/home/list')
          })
          .catch((err) => {
            errorToast(err)
          })
      },

      // 分离 单选和多选数组
      duoxuan() {
        this.questions.forEach((item, i) => {
          if (item.q_type == '多选') {
            this.multiple.push(item)
            this.dData.push(item.id)
          }
          if (item.q_type == '单选') {
            this.single.push(item)
          }
        })
      },

      //
      status(status) {
        if (status == 0) {
          errorToast('该问卷已截止')
          this.$router.push('/home/list')
        }
      },

      // 去出数组空值
      removeEmpty(arr) {
        var brr = [];
        arr.map(function(val, index) {
          //过滤规则为，不为空串、不为null、不为undefined，也可自行修改
          if (val !== "" && val != undefined) {
            brr.push(val);
          }
        });
        return brr;
      },
    },

    computed: {
      singleNum() {
        let i = 0
        this.questions.forEach((item, i) => {
          if (item.q_type == '单选') {
            i = i + 1
          }
        })
        return i
      },
      multipleNum() {
        let i = 0
        this.questions.forEach((item, i) => {
          if (item.q_type == '多选') {
            i = i + 1
          }
        })
        return i
      }
    },

    async created() {
      this.n_id = this.$route.params.id
      await this.getQuestion(this.$route.params.id)
      // console.log(this.$refs.rad)  ref作为渲染结果被创建 在初始渲染时访问不到他
      this.duoxuan()
      console.log(this.single)
    },
    mounted() {

    }
  }
</script>

<style scoped="scoped">
  @media screen and (min-width: 800px) {
    .container {
      margin-top: 40px;
      width: 700px;
      height: 100%;
      padding: 40px;
      background: #fff;
      border: 1px solid #eaeaea;
      box-shadow: 0 0 25px #cac6c6;
      margin:40px auto;
    }

    .title {
      width: 100%;
      height: 30px;
      line-height: 30px;
      font-size: 24px;
      text-align: center;
    }

    .main {
      margin-top: 20px;
    }

    .el-button {
      margin-top: 20px;
    }

    .el-radio {
      margin: 5px 0;
    }

    .el-checkbox {
      margin: 5px 0;
    }
  }

  @media screen and (max-width: 800px) {
    .container {
      width: 100%;
      height: 100%;
      font-size: 0.8rem;
    }

    .title {
      width: 100%;
      height: 1.5rem;
      line-height: 1.5rem;
      font-size: 1rem;
      text-align: center;
    }

    .main {
      margin-top: 2rem;
      margin-left: 2rem;
    }

    .item {
      margin: 15px;
    }

    .el-radio {
      margin: 0.3rem 0;
    }

    .el-checkbox {
      margin: 0.3rem 0;
    }

    .el-button {
      margin-left: 40%;
    }

    .opt {}
  }
</style>
