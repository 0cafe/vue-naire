<template>
  <div class="container">
    <h2 class="page-header">问卷管理</h2>
    <div class="add">
      <div class="title-box" v-show="!nowNaire.n_title">
        <span>新建问卷:</span>
        <input type="text" class="form-control Put" v-model="newNaire.n_title" placeholder="输入新问卷标题" />
        <el-button type="primary" size="small" @click="submitNaire">新建问卷</el-button>
        <span>选择已有问卷:</span>
        <el-select v-model="nowNaire" @visible-change="toggleSelect" placeholder="请选择已有问卷">
          <el-option v-for="item in naire" :key="item.n_id" :label="item.n_title" :value="item">
          </el-option>
        </el-select>
      </div>

      <div class="title-box" v-if="nowNaire.n_title">
        id:{{nowNaire.n_id}}.{{nowNaire.n_title}}
      </div>

      <div class="question-box" v-if="nowNaire.n_title">
        <div class="question-left">
          <el-table :data="questionData" style="width:400px">
            <el-table-column prop="q_id" label="问卷id" width="50">
            </el-table-column>
            <el-table-column prop="q_content" label="题目" width="150">
            </el-table-column>
            <el-table-column prop="q_type" label="题型" width="50">
            </el-table-column>
            <el-table-column label="操作" width="70">
              <template slot-scope="scope">
                <el-button type="danger" size="mini" @click="deleteQs(scope.row.q_id)">删除</el-button>
              </template>
            </el-table-column>



          </el-table>
          <el-button type="primary" size="mini" :class="[selfbtn]" @click="GetQuestion(nowNaire.n_id)">查看已添加题目</el-button>
        </div>

        <div class="question-right">
          <el-form ref="questionForm" label-width="100px" :model="newQuestion" size="mini">
            <el-form-item label="问题" :required="true" prop="q_content">
              <el-input v-model="newQuestion.q_content" style="width:250px"></el-input>
            </el-form-item>
            <el-form-item label="所属问卷id" :required="true" prop="n_id">
              <el-input v-model="newQuestion.n_id" style="width:250px"></el-input>
            </el-form-item>
            <el-form-item label="题目类型" :required="true" prop="q_type">
              <el-radio-group v-model="newQuestion.q_type">
                <el-radio label="单选">单选</el-radio>
                <el-radio label="多选">多选</el-radio>
              </el-radio-group>
            </el-form-item>

            <el-form-item size="small">
              <el-button type="primary" @click="submitQuestion()">立即创建</el-button>
              <el-button @click="reset('questionForm')">取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>

      <el-divider v-if="nowNaire.n_title"></el-divider>
      <!-- 选项添加区域 -->
      <div class="option-box" v-if="nowNaire.n_title">
        <div class="option-left">
          <el-table :data="optionData" style="width:400px">
            <el-table-column prop="o_id" label="选项id" width="50">
            </el-table-column>
            <el-table-column prop="o_value" label="选项" width="100">
            </el-table-column>
            <el-table-column prop="n_id" label="问卷id" width="50">
            </el-table-column>
            <el-table-column prop="q_id" label="题目id" width="50">
            </el-table-column>
            <el-table-column label="操作" width="70">
              <template slot-scope="scope">
                <el-button type="danger" size="mini" @click="deleteOpt(scope.row.o_id)">删除</el-button>
              </template>
            </el-table-column>

          </el-table>
          <el-button type="primary" size="mini" :class="[selfbtn]" @click="GetOption(nowNaire.n_id)">查看已添加选项</el-button>
        </div>

        <div class="option-right">
          <el-form ref="optionForm" label-width="100px" :model="newOption" size="mini">
            <el-form-item label="选项" :required="true" prop="o_value">
              <el-input v-model="newOption.o_value" style="width:250px"></el-input>
            </el-form-item>
            <el-form-item label="所属问卷id" :required="true" prop="n_id">
              <el-input v-model="newOption.n_id" style="width:250px"></el-input>
            </el-form-item>
            <el-form-item label="所属题目id" :required="true" prop="q_id">
              <el-input v-model="newOption.q_id" style="width:250px"></el-input>
            </el-form-item>
            <el-form-item size="small">
              <el-button type="primary" @click="submitOption()">立即创建</el-button>
              <el-button @click="reset('optionForm')">取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    post,
    get,
    _delete
  } from '../axios/api.js'
  import {
    errorToast,
    successToast
  } from '@/common/toast'
  export default {
    data() {
      return {
        selfbtn: 'selfbtn', //自定义el组件样式类
        naire: '',
        nowNaire: {
          n_id: '',
          n_title: ''
        },
        nowQuestion: {
          n_id: '',
          n_title: ''
        },
        type: '单选',
        newNaire: {
          n_title: '',
          n_status: ''
        },
        newQuestion: {
          q_content: '',
          q_type: '',
          n_id: ''
        }, //
        addOptions: [],
        option: {
          o_value: '',
          n_id: '',
          q_id: ''
        },
        open: true,
        n_id: '',
        q_id: '',
        questionData: [],
        optionData: [],
        newOption: {
          o_value: '',
          n_id: '',
          q_id: ''
        }
      }
    },
    methods: {
      async GetNaire() {
        await this.$api.get('/Naire')
          .then((res) => {
            this.naire = res.data
          })
      },
      async submitNaire() {
        if (!this.newNaire.n_title || !isNaN(this.newNaire.n_title)) {
          this.errorToast('问卷标题不合法')
          return
        }
        await post('/Naire', this.newNaire)
          .then((res) => {

            this.nowNaire.n_id = res
            this.successToast('添加问卷成功')
          })
          .catch(res => {
            this.errorToast(res)
          })
        this.nowNaire.n_title = this.newNaire.n_title

        this.GetQuestion(this.nowNaire.n_id)
      },
      async GetQuestion(nid) {
        if (!nid) {
          return
        }
        await this.$api.get('/Question/' + nid)
          .then((res) => {
            this.questionData = res.data
          })
      },
      async submitQuestion() {
        if (!this.newQuestion.q_content || !this.newQuestion.q_type || !this.newQuestion.n_id) {
          this.errorToast('请完整填写')
          return
        } else {
          await post('/Question', this.newQuestion)
            .then(res => {

              this.successToast('添加成功')
            })
            .catch(err => {
              this.errorToast('添加失败')
            })
        }
        this.newQuestion.q_content = ''
        this.GetQuestion(this.nowNaire.n_id)
      },
      async GetOption(nid) {
        if (!nid) {
          return
        }
        await this.$api.get('/Options/' + nid)
          .then((res) => {
            this.optionData = res.data
          })
      },
      async submitOption() {
        if (!this.newOption.o_value || !this.newOption.n_id || !this.newOption.q_id) {
          this.errorToast('请完整填写')
          return
        } else {
          await post('/Options', this.newOption)
            .then(res => {

              this.successToast('添加成功')
            })
            .catch(err => {
              this.errorToast('添加失败' + err)
            })
        }
        this.GetOption(this.nowNaire.n_id)
        this.newOption.o_value = ''
      },
      async deleteQs(id) {
        await this.$api.post('/deleteQuestion/' + id)
          .then(res => {

            this.successToast(res.data)
          })
          .catch(err => {

          })
        this.GetQuestion(this.nowNaire.n_id)
      },
      async deleteOpt(id) {
        await this.$api.post('/deleteOption/' + id)
          .then(res => {

            this.successToast(res.data)
          })
          .catch(err => {

          })
        this.GetOption(this.nowNaire.n_id)
      },
      reset(formName) {
        this.$refs[formName].resetFields(); //要个每个item绑定prop值 prop = from.xx
      },
      toggleSelect() {
        this.GetNaire()
      },
      successToast(msg) {
        this.$notify({
          title: '成功',
          message: msg,
          type: 'success',
          duration: 3000
        });
      },
      errorToast(msg) {
        this.$notify({
          title: '错误',
          message: msg,
          type: 'error',
          duration: 3000
        });
      }
    },
    created() {

    },
    computed: {

    },
    watch: {
      //      nowNaire:{              //深度监听 可监听到对象、数组的变化
      //           hanlder(newVal,oldVal){   //使用字符串的形式监听单个对象属性：
      //
      //               console.log(newVal)
      //           },
      //           deep:true
      //      }
    },
  }
</script>

<style scoped="scoped">
  .page-header {
    color: #0a8fee;
    font-family: "Microsoft JhengHei";
  }

  .Put {
    display: inline-block;
    margin-left: 100px;
    width: 300px;
    margin: 10PX;
  }

  .question {
    display: inline-block;
    width: 300px;
  }

  .addForm {
    position: absolute;
    left: 40%;
    top: 30%;
    height: 400px;
    width: 400px;
    border: 1px solid #000000;
    z-index: 100;
  }

  .add {
    width: 100%;
  }

  .title-box {
    margin: 0 auto;
    width: auto;
    text-align: center;
    line-height: 70px;
    height: 70px;
    border-bottom: 1px solid #1111;
    font-size: 20px;
  }

  .btn {
    margin-left: 10px;
    margin-right: 100px;
  }

  .myTable {}

  .selfbtn {
    margin: 15px;
  }

  .question-box,
  .option-box {
    margin-top: 80px;
    display: flex;
    justify-content: flex-start;
  }
</style>
