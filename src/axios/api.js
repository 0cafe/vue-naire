// 封装axios
import axios from 'axios'
import QS from 'qs'
import router from '@/router'

const config = {
  baseURL: baseURL || '',
  timeout: 10 * 1000, // 请求超时时间设置
  crossDomain: true,
  // withCredentials: true, // Check cross-site Access-Control
  // 定义可获得的http响应状态码
  // return true、设置为null或者undefined，promise将resolved,否则将rejected
  validateStatus(status) {
    return status >= 200 && status < 510
  }
}
const api = axios.create(config);


// http request 拦截器
api.interceptors.request.use(
  config => {
    if (localStorage.token) { // 判断是否存在token，如果存在的话，则每个http header都加上token
      config.headers.Authorization = `token ${localStorage.token}`
    }
    return config
  },
  err => {
    return Promise.reject(err)
  })


// http response 拦截器   服务端有返回东西就不会走到error
api.interceptors.response.use(
  response => {
    if( response.status == 403  ){
      localStorage.removeItem('token')
      localStorage.removeItem('username')
      alert('登录失效,请重新登录')
      router.push('/login')
    }
    return response;
  },
  error => {
     console.log(error)
    if (error.response) {
      switch (error.response.status) {
        case 403:
          // 返回 403 无权限
      }
    }
    return Promise.reject(error.response.data) // 返回接口返回的错误信息
  });


// 导出常用方法
export function get(url, params) {
  return new Promise((resolve, reject) => {
    api.get(url, {
        params: params
      })
      .then(res => {
        resolve(res.data);
      })
      .catch(err => {
        reject(err.data)
      })
  });
}
/**
 * post方法，对应post请求
 * @param {String} url [请求的url地址]
 * @param {Object} params [请求时携带的参数]
 */
export function post(url, params) {
  return new Promise((resolve, reject) => {
    api.post(url, QS.stringify(params))
      .then(res => {
        resolve(res.data);
      })
      .catch(err => {
        reject(err.data)
      })
  });
}

export function put(url, params) {
  return new Promise((resolve, reject) => {
    api.put(url, QS.stringify(params))
      .then(res => {
        resolve(res.data);
      })
      .catch(err => {
        reject(err.data)
      })
  });
}

export function _delete(url, params = {}) {
  return api({
    method: 'delete',
    url,
    params,
  })
}


// 删除
// export function _delete(url, params) {
//     return new Promise((resolve, reject) => {
//         axios.delete(url,{
//             params: params
//         })
//         .then(res => {
//             resolve(res.data);
//         })
//         .catch(err => {
//             reject(err.data)
//         })
//     });
// }

export default api
