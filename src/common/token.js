import {get} from '@/axios/api.js'

export default function valitoken(){
  get('valid').then(res=>{
    if(!res.token){
      localStorage.removeItem('token')
      localStorage.removeItem('username')
      localStorage.removeItem('auth')
      // window.location = "/#/login"
      return false
    }
    return true
  })
}
