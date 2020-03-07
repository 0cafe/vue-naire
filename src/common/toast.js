import vm from '@/main'

export function successToast(msg){
        vm.$notify({
          title: '成功',
          message: msg,
          type: 'success',
          duration:3000
        });
      }
 export function errorToast(msg){
        vm.$notify({
          title: '错误',
          message: msg,
          type: 'error',
          duration:3000
        });
        }
