<template>
  <div class="container" v-loading="loading">
    <div class="toolbar">
      <!-- <div class="ntitle">编辑</div> -->
      <div></div>
      <!-- <div class="el-icon-back" @click="back"></div> -->
    </div>
    <el-form :model="form" label-width="80px" ref="form">
      <el-form-item label="问卷标题">
        <el-input v-model="form.n_title" maxlength="30" show-word-limit></el-input>
      </el-form-item>
    </el-form>
    <div class="button-group">
      <!-- <div>tip : 点这里添加题目 </div> -->
      <el-button type="primary" size="small" @click="addQuestion">单选题 + </el-button>
      <el-button type="primary" size="small" @click="addMultiplyQuestion">多选题 + </el-button>
    </div>

    <div class="question-wrap single-box">
      <div v-for="(question,qindex) in form.questions">
        <div class="question">

          <el-form :model="form" label-width="80px" ref="form" size="medium" v-if="question.q_type == '单选'">
            <el-form-item :label="'单选题'+' '+(qindex+1)">
              <el-input v-model="form.questions[qindex].q_content" maxlength="30" show-word-limit></el-input>
              <el-button type="primary" icon="el-icon-plus" circle @click="addOption(qindex)"></el-button>
              <el-button type="danger" icon="el-icon-delete" circle @click="delQuestion(qindex)"></el-button>
            </el-form-item>
            <template v-for="(option,oindex) in form.questions[qindex].option">
              <el-form-item :label="'选项'+(oindex+1)">
                <el-input v-model="form.questions[qindex].option[oindex].o_value" maxlength="15" show-word-limit></el-input>
                <el-button type="danger" icon="el-icon-delete" circle @click="delOption(qindex,oindex)"></el-button>
              </el-form-item>
            </template>
          </el-form>

          <el-form :model="form" label-width="80px" ref="form" size="medium" v-if="question.q_type == '多选'">
            <el-form-item :label="'多选题'+' '+(qindex+1)">
              <el-input v-model="form.questions[qindex].q_content" maxlength="30" show-word-limit></el-input>
              <el-button type="primary" icon="el-icon-plus" circle @click="addOption(qindex)"></el-button>
              <el-button type="danger" icon="el-icon-delete" circle @click="delQuestion(qindex)"></el-button>
            </el-form-item>
            <template v-for="(option,oindex) in form.questions[qindex].option">
              <el-form-item :label="'选项'+(oindex+1)">
                <el-input v-model="form.questions[qindex].option[oindex].o_value" maxlength="10" show-word-limit></el-input>
                <el-button type="danger" icon="el-icon-delete" circle @click="delOption(qindex,oindex)"></el-button>
              </el-form-item>
            </template>
          </el-form>

        </div>
      </div>
    </div>

    <div class="submit">
      <el-button type="success" @click="submitForm()">修改问卷</el-button>
    </div>
  </div>
</template>

<script>
  import {
    get,
    post,
    put,
    _delete
  } from '@/axios/api.js'
  import {
    errorToast,
    successToast,
    warningToast
  } from '@/common/toast'
  export default {
    data() {
      return {
        loading: true,
        flag: true,
        form: {}
      }
    },
    methods: {
      //获取
      async getNaire(id) {
        await get('/naire/' + id)
          .then(res => {
            console.log(res)
            this.form = res
            this.loading = false
          })
      },
      //提交
      submitForm() {
        // this.form.n_status = status
        let validated = this.validate(this.form)
        if (!validated) {
          return
        }
        put('naire/edit', this.form).then(res => {
          if (res.error_code === 0) {
            successToast(res.msg)
            this.$router.push('/home/list')
            return
          } else {
            errorToast(res.msg)
            return
          }
        })
      },
      //添加单选题
      addQuestion() {
        let question = {
          q_content: '',
          q_type: '单选',
          option: [{
            o_value: '选项一'
          }]
        }
        this.form.questions.push(question)
      },
      async delQuestion(id) {

        if (this.form.questions.length == 1) {
          return warningToast('已经是最后一题啦')
        }

        let q_id = this.form.questions[id].id
        if (this.form.questions[id].id) {
          this.$confirm('此操作将永久删除该问题, 是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(async () => {
            let res = await _delete('question/' + q_id)
            console.log(res.data)
            this.form.questions.splice(id, 1)
            if (res.data.error_code === 0) {
              successToast('删除成功')
            }
          })
        } else {
          this.form.questions.splice(id, 1)
        }
      },
      //添加 多选题
      addMultiplyQuestion() {
        let question = {
          q_content: '',
          q_type: '多选',
          option: [{
            o_value: '选项一'
          }]
        }
        this.form.questions.push(question)
      },
      //添加选项
      addOption(qid) {
        if (this.form.questions[qid].option.length >= 7) {
          return warningToast('一题最多添加7个选项噢')
        }
        let option = {
          o_value: '1'
        }
        this.form.questions[qid].option.push(option)
      },
      async delOption(qid, oid) {
        if (this.form.questions[qid].option.length == 1) {
          return warningToast('已经是最后一个啦')
        }

        let o_id = this.form.questions[qid].option[oid].id
        if (this.form.questions[qid].option[oid].id) {
          this.$confirm('此操作将永久删除该选项, 是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
          }).then(async () => {
            await _delete('option/' + o_id).then((res) => {
              if (res.error_code === 0) {
                successToast('删除成功')
              }
              this.form.questions[qid].option.splice(oid, 1)
            })
          })
        } else {
          this.form.questions[qid].option.splice(oid, 1)
        }
      },

      // 表单验证规则
      validate(data) {
        let flag = true
        if (!data || !data.n_title) {
          errorToast('请完整填写')
          return false
        }
        this.form.n_title = this.form.n_title.trim()
        if (data.n_title.length < 5) {
          errorToast('问卷标题不少于五个字')
          return false
        }

        data.questions.forEach((item, i) => {
          if (item.q_content == '' || !item.q_content) {
            errorToast('请完整填写')
            flag = false
          }
          item.option.forEach((tem, o) => {
            if (tem.o_value == '' || !tem.o_value) {
              errorToast('请完整填写')
              flag = false
            }
          })
        })
        return flag
      },
      //
      back() {
        this.$router.back()
      },
    },

    async created() {
      this.getNaire(this.$route.params.id)
    }
  }
</script>

<style scoped="scoped" lang="scss">
  .container {
    // border: 1px solid;
    width: 80%;
    height: 100%;
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    .el-form {
      width: 100%;
    }

    .button-group {
      display: flex;
      justify-content: center;
    }
  }

  .single-box {

    width: 1000px;
    background-color: #f9f9f9;
    padding: 20px;
    margin-top: 30px;

    .el-input {
      width: 500px;
    }

    .el-form,
    el-form {
      margin-bottom: 30px;
    }

    .el-button {
      margin-left: 20px;
    }
  }

  .question {
    // margin-bottom: 20px;
    padding-top: 20px;
    border-bottom: 5px dashed #FFFFFF;
  }

  .submit {
    margin-top: 30px;
  }

  .button-group {
    height: 35px;
    line-height: 35px;

    div {
      margin-right: 20px;
    }
  }

  .toolbar {
    display: flex;
    justify-content: space-between;
    padding: 0 100px 0px 50px;
    font-size: 22px;
    height: 60px;
    line-height: 60px;
    width: 100%;
  }

  .el-icon-back {
    font-size: 0.5rem;
    color: #0a8fee !important;
  }

  .ntitle {
    color: #0a8fee;
    font-family: "Microsoft JhengHei";
  }
</style>
