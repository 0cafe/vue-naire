<template>
  <div class="container">
    <el-table v-if="!isResult" v-loading="loading" :data="tableData" border>
      <el-table-column prop="create_time" label="创建时间" width="200">
      </el-table-column>

      <el-table-column prop="n_title" label="问卷标题" width="600">
        <template slot-scope="scope">
          <router-link :to="'/fill/'+scope.row.n_id + '/' + scope.row.n_status ">
            {{scope.row.n_title}}
          </router-link>
        </template>
      </el-table-column>
      <el-table-column prop="n_status" label="发布状态" width="200">
        <template slot-scope="scope">
          <!-- <span>{{ scope.row.n_status == 1 ? '发布中':'已截止' }}</span>
        <el-button type="warning" size="small" @click="status(scope.row)">发布/截止</el-button> -->
          <!-- 坑:这里active-value后台给的是number类型  加""不生效 -->
          <el-switch v-model="scope.row.n_status" :active-value=1 :inactive-value=0 active-text="发布中" inactive-text="截止">
          </el-switch>
        </template>

      </el-table-column>
      <el-table-column label="操作" width="300">
        <template slot-scope="scope">
          <!-- <router-link :to="'/result/' + scope.row.n_id">
       <el-button type="primary" size="small">查看结果</el-button>
         </router-link> -->
          <el-button type="danger" size="small" @click="deleteNaire(scope.row.id)">删除</el-button>
          <el-dropdown size="small">
            <el-button size="small" type="primary">
              更多菜单<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>

            <!--这里下拉菜单item使用@click.native  给组件绑定点击事件要加native 相当于emit('click'.fn)-->
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item @click.native="toResult(scope.row.id)">查看结果</el-dropdown-item>
              <el-dropdown-item @click.native="toEdit(scope.row.id)">编辑</el-dropdown-item>
              <el-dropdown-item @click.native="toCtrl(scope.row.id)">复制链接</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>

        </template>
      </el-table-column>
    </el-table>
    <result v-if="isResult" @close="close" :id="resultID" ></result>
  </div>
</template>

<script>
  import {
    errorToast,
    successToast
  } from '@/common/toast'
  import {
    get,
    post,
    _delete
  } from '../axios/api.js'
  import result from './result.vue'
  export default {
    name: 'home',
    components:{
      result
    },
    data() {
      return {
        questionTitle: [],
        Tid: '',
        tableData: [],
        loading: true,
        resultID:'',
        isResult:false
      }
    },
    methods: {
      async GetQuestion() {
        await this.$api.get('/Naire')
          .then((res) => {

            this.tableData = res.data
            console.log(this.tableData)
          })
        this.loading = false
      },

      //删除
      deleteNaire(id) {
        this.$confirm('此操作将永久删除该问卷, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          _delete('/naire/' + id)
            .then(res => {
              if (res.data.error_code === 0) {
                successToast(res.data.msg)
                this.GetQuestion();
              }
            })
        })
      },
      async status(obj) {
        if (obj.n_status == 1) {
          obj.n_status = 0
        } else {
          obj.n_status = 1
        }
        let nowNaire = {
          n_id: obj.n_id,
          n_title: obj.n_title,
          n_status: obj.n_status
        }

        await post('/updateNaire', nowNaire)
          .then(res => {
            successToast('修改发布状态成功')
          })
          .catch(err => {
            errorToast('修改发布状态失败')
          })
      },

      // 菜单 跳转结果
      toResult(id) {
        this.resultID = id
        this.isResult = true
      },
      toEdit() {

      },
      toCtrl() {

      },
      //关闭组件 回到表格页面
      close(){
        this.isResult = false
      }

    },
    async created() {
      await this.GetQuestion();
    }
  }
</script>

<style scoped="scoped">
  a {
    text-decoration: none;
  }

  .container {
    width: 100%;
  }

  .results {
    float: right;
  }

  .question {
    font-size: 20px;
  }

  .question-list {

    font-size: 20px;
    color: blue;
  }

  a:hover {
    text-decoration: none;
    color: red;
  }

  a {
    color: #222;
    font-weight: 200;
  }

  .page-header {
    color: #0a8fee;
    font-family: "Microsoft JhengHei";
  }

  .list-group-item {
    border: 1px solid #0a8fee;
  }
</style>
