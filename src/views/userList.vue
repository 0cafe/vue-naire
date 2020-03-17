<template>
  <div class="container">
    <el-table v-loading="loading" :data="tableData">
      <el-table-column prop="id" label="id">
      </el-table-column>
      <el-table-column prop="a_username" label="用户名">
      </el-table-column>
      <el-table-column prop="create_time" label="注册时间">
      </el-table-column>
      <el-table-column prop="last_login_time" label="最后登录时间">
      </el-table-column>
      <el-table-column prop="last_login_ip" label="最后登录IP">
      </el-table-column>
      <el-table-column prop="status" label="状态">
        <template slot-scope="scope">
          <el-switch @change="modifyStatus(scope.row.id)" v-model="scope.row.status" :active-value=1 :inactive-value=0
            active-text="正常" inactive-text="封禁">
          </el-switch>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import {get,put} from '@/axios/api.js'
  import {
    errorToast,
    successToast
  } from '@/common/toast'
  export default {
    data() {
      return {
        tableData: [],
        loading:true
      }
    },
    methods: {
       async getUsers(){
        await get('/admin/user').then(res=>{
           console.log(res)
           this.tableData = res
           this.loading = false
         })
       },
       async modifyStatus(id){
         this.loading = true
         await put('/admin/user/'+id).then(res => {
           if (res.error_code == 0) {
             setTimeout(()=>{
               this.loading = false
               successToast('修改状态成功')
             },500)
           }
         })
       }
    },
    async created() {
       this.getUsers()
    }
  }
</script>

<style>
</style>
