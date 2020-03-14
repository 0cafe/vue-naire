<template>
  <div class="container" v-loading="loading">
    <div class="toolbar">
      <div class="ntitle">{{title}}</div>
      <div class="el-icon-back" @click="back">关闭</div>
    </div>
    <div class="question" v-for="(item,i) in questions">
      <!-- <p>{{i+1}}.{{item.q_content}}</p> -->
      <div :id="'chart-'+ item.id" class="chart">

      </div>
    </div>
  </div>
</template>

<script>
  import echarts from 'echarts'
  export default {
    props: ['id'],
    data() {
      return {
        title: '',
        questions: [],
        options: [],
        result: [],
        loading: true
      }
    },
    methods: {

      async getNaire(id) {
        await this.$api.get('/v1/naire/' + id)
          .then((res) => {
            // console.log(res.data)
            this.title = res.data.n_title
          })
      },

      async getQuestion(id) {
        await this.$api.get('/v1/question/' + id)
          .then(res => {
            // console.log(res.data)
            this.questions = res.data
          })
      },

      async getReults(id) {
        await this.$api.get('/v1/result/' + id)
          .then(res => {
            // console.log(res.data)
            this.result = res.data
          })
      },

      async getOption(id) {
        await this.$api.get('/v1/options/' + id)
          .then(res => {
            // console.log(res.data)
            this.options = res.data
          })
      },

      getO(id) { //按题目ID获取选项
        let option = []
        this.options.forEach((item, i, arr) => {
          if (item.q_id === id) {
            option.push(item.o_value)
          }
        })
        // console.log(option)
        return option;
      },

      //查看多选题的答案
      checkBoxResult(arr, index) {
        let s = [] //当前题目的所有答案
        arr.forEach((item, i) => {
          if (item.q_id == index) {
            s.push(item.o_value)
          }
        })
        return s.reduce(function(pre, item, i) {
          pre[item] ? pre[item]++ : pre[item] = 1;
          return pre;
        }, {});
      },

      // 计算单选题的答案
      radioResult(arr, index) {
        let s = [] //当前题目的所有答案
        arr.forEach((item, i) => {
          if (item.q_id == index) {
            s.push(item.o_value)
          }
        })

        return s.reduce(function(pre, item, i) {
          // obj['a'] === obj.a  这里pre.item 指向pre  所以要用[]取对象的值
          pre[item] ? pre[item]++ : pre[item] = 1;
          return pre;
        }, {});
      },

      // 统计图函数
      drawChart(data, i) {
        let myChart = echarts.init(document.getElementById("chart-" + data.id))
        //x轴数据
        let xData = this.getO(data.id)
        //Y轴数据
        let yData = this.radioResult(this.result, data.id)
        // console.log(yData)
        //单选题
        if (data.q_type == '单选') {
          myChart.setOption({
            title: {
              text: data.q_content
            },
            tooltip: {},
            xAxis: {
              data: xData, // ["2013年6月", "2014年6月", "2015年6月", "2016年6月"]
              axisLabel: {
                interval: 0, //横轴信息全部显示
                margin: 10
                // formatter:function(xData){
                // return xData.split("").join("\n");} //横轴信息文字竖直显示
              }
            },
            yAxis: {},
            series: [{
              showAllSymbol: true,
              name: '选择人数',
              type: 'bar',
              data: [
                yData[xData[0]], yData[xData[1]], yData[xData[2]], yData[xData[3]], yData[xData[4]],
                yData[xData[5]], yData[xData[6]], yData[xData[7]]
              ]
            }]
          })
          // 多选题
        } else if (data.q_type == '多选') {
          console.log(this.checkBoxResult(this.result, data.id))
          let obj = this.checkBoxResult(this.result, data.id)
          let value;
          let name;
          let Data = [];
          for (let i in obj) { //遍历处理答案的对象 插入到一个数组data
            let objj = {
              value: obj[i],
              name: i
            }
            Data.push(objj)
          }
          // console.log(Data)
          myChart.setOption({
            title: {
              text: data.q_content
            },
            tooltip: {
              trigger: 'item',
              formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            color: ['#CD5C5C', '#00CED1', '#9ACD32', '#FFC0CB'],
            stillShowZeroSum: false,
            series: [{
              name: 'bug分布',
              type: 'pie',
              radius: '80%',
              center: ['60%', '60%'],
              data: Data,
              itemStyle: {
                emphasis: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: 'rgba(128, 128, 128, 0.5)'
                }
              }
            }]
          })
        }
      },
      sort() {
        let option = []
        this.options.forEach((item, i, arr) => {
          if (item.q_id === id) {
            option.push(item)
          }
        })
        this.questions.forEach((item, i) => {
          this.drawChart(item)
        })
      },
      //
      back() {
        this.$emit('close')
      }
    },
    async created() {
      await this.getNaire(this.id)
      await this.getQuestion(this.id)
      await this.getReults(this.id)
      await this.getOption(this.id)
      this.questions.forEach((item, i) => {
        this.drawChart(item, i)
      })
      this.loading = false
    },
    mounted() {
      // this.$nextTick(()=>{
      //   this.questions.forEach((item, i) => {
      //     this.drawChart(item, i)
      //   })
      //   this.loading = false
      // })
    }

  }
</script>

<style scoped="scoped">
  .container {

  }

  .toolbar {
    display: flex;
    justify-content: space-between;
    padding: 0 100px 0px 50px;
    font-size: 22px;
    height: 50px;
    line-height: 50px;
    width: 100%;
  }

  .el-icon-back {
    font-size: 0.2rem;
    cursor: pointer;
    color: #0a8fee !important;
  }

  .ntitle {
    color: #0a8fee;
    font-family: "Microsoft JhengHei";
  }

  .question {
    width: 100%;
    height: auto;
  }

  .chart {
    width: 50%;
    height: 300px;
    margin: 50px auto;
  }
</style>
