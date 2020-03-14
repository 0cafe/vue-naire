<template>
  <div class="container">
    <el-table v-if="!isResult" v-loading="loading" :data="tableData">
      <el-table-column prop="create_time" label="创建时间" width="200">
      </el-table-column>

      <el-table-column prop="n_title" label="问卷标题" width="600">
        <template slot-scope="scope">
          <router-link :to="'/naire/'+scope.row.id">
            {{scope.row.n_title}}
          </router-link>
        </template>
      </el-table-column>
      <el-table-column prop="n_status" label="发布状态" width="200">
        <template slot-scope="scope">
          <!-- <span>{{ scope.row.n_status == 1 ? '发布中':'已截止' }}</span>
        <el-button type="warning" size="small" @click="status(scope.row)">发布/截止</el-button> -->
          <!-- 坑:这里active-value后台给的是number类型  加""不生效 -->
          <el-switch @change="modifyStatus(scope.row.id)" v-model="scope.row.n_status" :active-value=1 :inactive-value=0
            active-text="发布中" inactive-text="截止">
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
              <el-dropdown-item @click.native="toEdit(scope.row)">编辑</el-dropdown-item>
              <el-dropdown-item @click.native="toCtrl(scope.row.id)">复制链接</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>

        </template>
      </el-table-column>
    </el-table>
    <result v-if="isResult" @close="close" :id="resultID"></result>
    <share-url v-if="isShare" @close="close" :url = "url"></share-url>
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
    put,
    _delete
  } from '../axios/api.js'
  import result from './result.vue'
  import shareUrl from '@/components/url.vue'
  export default {
    name: 'home',
    components: {
      result,
      shareUrl
    },
    data() {
      return {
        questionTitle: [],
        Tid: '',
        tableData: [],
        loading: true,
        resultID: '',
        isResult: false,
        isEdit:false,
        editID:'',
        url:'',
        isShare:false
      }
    },
    methods: {
      async GetQuestion() {
        await this.$api.get('/Naire')
          .then((res) => {
            // console.log(res)
            this.tableData = res.data
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
      //
      async modifyStatus(id) {
        this.loading = true
        await put('/naire/' + id).then(res => {
          if (res.error_code == 0) {
            setTimeout(()=>{
              this.loading = false
              successToast('修改发布状态成功')
            },500)
          }
        })
      },

      // 菜单 跳转结果
      toResult(id) {
        this.resultID = id
        this.isResult = true
      },
      toEdit(data) {
        if(data.n_status == 1){
          return errorToast('问卷发布中无法编辑')
        }
        this.$router.push('/edit/'+data.id)
      },
      toCtrl(id) {
        this.isShare = true
        let host = window.location.host
        let url = host + '/#/' + 'naire/' + id
        this.url = url
      },
      //关闭组件 回到表格页面
      close() {
        this.isResult = false
        this.isEdit = false
        this.isShare = false
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
    margin-top: 30px;
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
