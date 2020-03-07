<template>
 <div class="container" v-loading="loading">

  <div v-for="(item,i) in questions" class="item">
    <p><span style="color: red;" v-if="item.q_isrequire == 1">*</span>{{i+1}}.{{item.q_content}}</p>

  <el-radio-group v-model="selectData[i]" v-if="item.q_type == '单选'" ref="radioM">
    <div v-for="(opt,index) in getO(item.q_id)" class="opt">
    <el-radio :label="opt">{{opt.o_value}}</el-radio>
    </div>
  </el-radio-group>

  <el-checkbox-group v-model="checkData" v-if="item.q_type == '多选'" :ref="'checkbox'+item.q_id">
    <div v-for="(opt,index) in getO(item.q_id)">
    <el-checkbox :label="opt">{{opt.o_value}}</el-checkbox>
    </div>
  </el-checkbox-group>

  </div>
  <el-button type="primary" round @click="submit()">提交</el-button>
 </div>
</template>

<script>
 import {post,get} from '../axios/api.js'
 import {errorToast,successToast} from '@/common/toast'
   export default{
    data(){
      return{
        questions:'',
        options:[],
        selectData:[],
        answer:[],
        checkData:[],
        loading:true,
        dData:[]    //多选题的q_id
      }
    },
    methods:{
        async getQuestion(id){
          await this.$api.get('/question/'+id)
          .then(res=>{
            // console.log(res.data)
            this.questions = res.data
          })
        },

        async getOptions(id){
          await this.$api.get('/options/'+id)
          .then(res=>{
            // console.log(res.data)
            this.options = res.data
          })
          this.loading = false
        },
        getO(id){      //按题目ID获取选项
          let option = []
          this.options.forEach((item,i,arr)=>{
            if(item.q_id === id){
              option.push(item)
            }
          })
          return option;
        },
        async submit(){
          let flag1 = true;
          let flag2 = true;

          if(this.$refs.radioM){
            let brr = this.$refs.radioM
            brr.forEach((item,i)=>{
              if(!item.value){
                flag1 = false
              }
            })
          }

          let checkId = [];
          this.checkData.forEach((item,i)=>{
            checkId.push(item.q_id)
          })
          this.dData.forEach((item,i)=>{
            if( checkId.indexOf(item) === -1){
              flag2 = false
            }
          })


          if(!flag1 || !flag2){
            return errorToast('请完整填写再提交')
          }

          let arr = [];
          arr = this.selectData.concat(this.checkData )
          if(arr.length < this.questions.length){
           return errorToast('请完整填写再提交')
          }
          await post('/result/',arr)
          .then((res)=>{
            successToast('提交成功')
            this.$router.push('/')
          })
          .catch((err)=>{
            errorToast(err)
          })
        },
         duoxuan(){
              this.questions.forEach((item,i)=>{
                if(item.q_type == '多选'){
                  this.dData.push(item.q_id)
                }
              })
         },
         status(status){
           if(status == 0){
             errorToast('该问卷已截止')
             this.$router.push('/')
           }
         }
    },
     async created(){
       this.status(this.$route.params.n_status)
       await this.getQuestion(this.$route.params.n_id)
       await this.getOptions(this.$route.params.n_id)
        // console.log(this.$refs.rad)  ref作为渲染结果被创建 在初始渲染时访问不到他
       this.duoxuan()
    },
    mounted(){

    }
  }
</script>

<style scoped="scoped">
  .item{
    margin: 15px;
  }
  .opt{

  }
</style>
