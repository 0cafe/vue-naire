webpackJsonp([13],{"09yM":function(e,t){},J7SL:function(e,t){},N9P1:function(e,t){},NHnr:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});n("briU");var o=n("kV13"),a=(n("I29D"),{name:"App",components:{},mounted:function(){document.getElementById("loader").style.display="none"}}),r={render:function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"container",attrs:{id:"app"}},[t("router-view")],1)},staticRenderFns:[]};var u=n("C7Lr")(a,r,!1,function(e){n("J7SL")},null,null).exports,i=n("YaEn"),c=n("c2Ch"),l=n("48sp");o.default.use(l.a);var m=new l.a.Store({state:{username:"",token:"",auth:""},mutations:{getUsername:function(e,t){e.username=t,localStorage.setItem("username",t)},getToken:function(e,t){(new Date).getTime();e.token=t.token,e.username=t.username,e.auth=t.auth,localStorage.setItem("token",t.token),localStorage.setItem("username",t.username),localStorage.setItem("auth",t.auth)},deleteToken:function(e,t){e.token="",e.username=null,e.auth=null,localStorage.removeItem("token"),localStorage.removeItem("username"),localStorage.removeItem("auth")}}}),s=n("TcQY"),d=n.n(s);n("09yM"),n("N9P1");function h(){var e=document.documentElement.clientWidth||document.body.clientWidth;console.log("屏幕宽度："+e);var t=document.getElementsByTagName("html")[0];t.style.fontSize=e/20+"px",console.log(t.style.fontSize)}o.default.config.productionTip=!1,o.default.prototype.$api=c.b,o.default.use(l.a),o.default.use(d.a),h(),window.onresize=function(){h()},localStorage.token&&localStorage.username&&(Object(c.c)("valid").then(function(e){return!!e.token||(localStorage.removeItem("token"),localStorage.removeItem("username"),localStorage.removeItem("auth"),!1)}),m.state.token=localStorage.token,m.state.username=localStorage.username),i.a.beforeEach(function(e,t,n){e.meta.requireAuth?localStorage.getItem("token")?n():n({path:"/login",query:{redirect:e.fullPath}}):n()}),console.log("production");var p=new o.default({router:i.a,store:m,render:function(e){return e(u)}}).$mount("#app");window.App=p;t.default=p},YaEn:function(e,t,n){"use strict";var o=n("kV13"),a=n("5inH"),r=n("IHPB"),u=n.n(r),i=[{path:"/home",redirect:"/home/about",name:"问卷管理",icon:"el-icon-document",component:function(){return n.e(1).then(n.bind(null,"26dS"))},meta:{requireAuth:!0},children:[{path:"about",name:"about",component:function(){return n.e(3).then(n.bind(null,"FBzZ"))},meta:{requireAuth:!0},auth:1,hidden:!0},{path:"list",name:"问卷列表",icon:"el-icon-reading",component:function(){return Promise.all([n.e(0),n.e(2)]).then(n.bind(null,"80bi"))},auth:1,meta:{requireAuth:!0}},{path:"create",name:"新建问卷",icon:"el-icon-document-add",component:function(){return Promise.all([n.e(0),n.e(9)]).then(n.bind(null,"Kimp"))},auth:1,meta:{requireAuth:!0}},{path:"/edit/:id",name:"编辑问卷",hidden:!0,auth:1,icon:"el-icon-document-add",component:function(){return Promise.all([n.e(0),n.e(5)]).then(n.bind(null,"yTGp"))},meta:{requireAuth:!0}}]}],c=[{path:"",redirect:"/home/user",name:"用户管理",icon:"el-icon-user",component:function(){return n.e(1).then(n.bind(null,"26dS"))},meta:{requireAuth:!0},children:[{path:"user",name:"用户列表",icon:"el-icon-user",component:function(){return Promise.all([n.e(0),n.e(7)]).then(n.bind(null,"Ql5M"))},meta:{requireAuth:!0},auth:2},{path:"edit",name:"修改密码",icon:"el-icon-reading",auth:1,component:function(){return Promise.all([n.e(0),n.e(11)]).then(n.bind(null,"oekV"))},meta:{requireAuth:!0}}]}],l=[{path:"/",name:"index",meta:{requireAuth:!0},hidden:!0,redirect:"/home"},{path:"/login",name:"login",hidden:!0,component:function(){return Promise.all([n.e(0),n.e(6)]).then(n.bind(null,"Quw4"))}},{path:"/register",name:"登陆",hidden:!0,component:function(){return Promise.all([n.e(0),n.e(10)]).then(n.bind(null,"c2lw"))}},{path:"/naire/:id",name:"问卷调查",hidden:!0,component:function(){return Promise.all([n.e(0),n.e(4)]).then(n.bind(null,"PDza"))}}].concat(u()(i),u()(c),[{path:"*",component:function(){return n.e(8).then(n.bind(null,"+H76"))},name:"404",hidden:!0}]);o.default.use(a.a);var m=new a.a({routes:l,scrollBehavior:function(){return{y:0}},linkActiveClass:"router-active"});t.a=m},c2Ch:function(e,t,n){"use strict";t.c=function(e,t){return new a.a(function(n,o){d.get(e,{params:t}).then(function(e){n(e.data)}).catch(function(e){o(e.data)})})},t.d=function(e,t){return new a.a(function(n,o){d.post(e,c.a.stringify(t)).then(function(e){n(e.data)}).catch(function(e){o(e.data)})})},t.e=function(e,t){return new a.a(function(n,o){d.put(e,c.a.stringify(t)).then(function(e){n(e.data)}).catch(function(e){o(e.data)})})},t.a=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return d({method:"delete",url:e,params:t})};var o=n("rVsN"),a=n.n(o),r=n("I29D"),u=n.n(r),i=n("atmG"),c=n.n(i),l=n("YaEn"),m=n("rBKV"),s=(n("dhIU"),{baseURL:m.BASE_URL||"",timeout:1e4,crossDomain:!0,validateStatus:function(e){return e>=200&&e<510}}),d=u.a.create(s);d.interceptors.request.use(function(e){return localStorage.token&&(e.headers.Authorization="token "+localStorage.token),e},function(e){return a.a.reject(e)}),d.interceptors.response.use(function(e){return 403==e.status&&(localStorage.removeItem("token"),localStorage.removeItem("username"),localStorage.removeItem("auth"),alert("登录失效,请重新登录"),l.a.push("/login")),e},function(e){return console.log(e),e.response&&e.response.status,a.a.reject(e.response.data)}),t.b=d},dhIU:function(e,t,n){"use strict";const o=n("zDq0"),a=n("rBKV");e.exports=o(a,{NODE_ENV:'"development"',BASE_URL:"http://naire/index.php/"})},rBKV:function(e,t,n){"use strict";e.exports={NODE_ENV:'"production"',BASE_URL:"/index.php/"}}},["NHnr"]);
//# sourceMappingURL=app.15384ef101720d8c3276.js.map