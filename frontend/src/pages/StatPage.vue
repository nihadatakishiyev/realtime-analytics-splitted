<template>
  <q-page padding>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="text-h4 q-mb-0 text-grey-8"> {{ card.name }} Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row q-col-gutter-lg">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-3 q-mb-4">
        <q-card class="my-card">
          <q-card-section>
            <div class="row no-gutters align-items-center q-pb-2">
              <div class="col-8">
                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">Aktiv İstifadəçilər( İndi)
                  {{ this.devCat['totalsForAllResults']['rt:activeUsers'] }}
                </div>
              </div>
              <div class="col-4 p1" v-if="this.devCat===null">
                <div class="h5 mb-0 font-weight-bold text-gray-800 float-right" :id="card.name + '1'">
                  Yüklənir...&nbsp;<i class="fa fa-spinner fa-spin text-gray-300"></i></div>
              </div>
            </div>

            <div class="row">
              <div class="box green mt-2"></div> &nbsp;
              <h6 style="font-size: 1vw">Desktop</h6>
              <div class="box yellow mt-2"></div> &nbsp;
              <h6 style="font-size: 1vw">Mobil</h6>
              <div class="box red mt-2"></div> &nbsp;
              <h6 id="tablet" style="font-size: 1vw">Tablet</h6>
            </div>

            <div class="progress" id="p1" style="height: 0.8rem">
              <div class="progress-bar bg-success" style="width:33%"></div>
              <div class="progress-bar bg-warning" style="width:34%"></div>
              <div class="progress-bar bg-danger" style="width:33%"></div>
            </div>
          </q-card-section>
        </q-card>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-3 mb-4">
        <q-card class="my-card">
          <q-card-section>
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-s font-weight-bold text-success text-uppercase mb-1">İstifadəçilər</div>
                <div class="h4 font-weight-bold text-gray-800" :id="card.name + '2'">Yüklənir...&nbsp;<i
                  class="fa fa-spinner fa-spin text-gray-300"></i></div>
              </div>
              <div class="col-auto mt-0">
                <i class="fa fa-user fa-2x text-gray-300 mt-0"></i>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>

      <div class="col-xl-3 col-md-3 mb-4">
        <q-card class="my-card">
          <q-card-section>
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-s font-weight-bold text-info text-uppercase mb-1">Sessiyalar</div>
                <div class="h4 font-weight-bold text-gray-800" :id="card.name + '3'">Yüklənir...&nbsp;<i
                  class="fa fa-spinner fa-spin text-gray-300"></i></div>
              </div>
              <div class="col-auto mt-0">
                <i class="fa fa-signal fa-2x text-gray-300 mt-0"></i>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-3 mb-4">
        <q-card class="my-card">
          <q-card-section>
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-s font-weight-bold text-warning text-uppercase mb-1">Bounce Rate</div>
                <div class="h4 font-weight-bold text-gray-800" :id="card.name + '4'">Yüklənir...&nbsp;<i
                  class="fa fa-spinner fa-spin text-gray-300"></i></div>
              </div>
              <div class="col-auto mt-0">
                <i class="fa fa-arrow-circle-up fa-2x text-gray-300 mt-0"></i>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <div class="row q-mb-4">

      <!-- Area Chart -->
      <div class="col-xl-7 col-lg-7">
        <q-card>
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Son 2 Həftədəki İstifadəçi Sayları</h6>
          </div>
          <!-- Card Body -->
          <q-card-section>
            <div class="chart-area">
              <div class="chart-container" style="position: relative;">
                <canvas id="weeks" style="max-height: 20rem"></canvas>
                <canvas-component :canvas="weeks"></canvas-component>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  // name: 'PageName',
  data () {
    return {
      id: null,
      weekChart:null,
      card: null,
      devCat: null,
      realtimeCallInterval: 15000,
      regularCallInterval: 60000
    }
  },
  methods: {
    ...mapActions('realtime', ['getCard', 'getDeviceCategory', 'bringUserStats']),
    getCats (id) {
      this.getDeviceCategory(id).then(res => {
        console.log(res)
        this.devCat = res.data.data
      })
    },
    bringUStats (id) {
      this.bringUserStats(id).then(response => {
        console.log(response)
        var res = {};
        var pass = [];
        var i = 0;
        var days = response.data.data.reports[0].data.rows;
        days.map(day => {
          if(parseInt(day.metrics[0].values[0]) === 0){
            res[day.dimensions[0]] = day.metrics[1].values[0];
          }
          else {
            res[day.dimensions[0]] = day.metrics[0].values[0];
          }
          pass.push(Object.values(res)[i])
          i++;
        })
        this.generateWeeksCanvas(pass, res, "weeks");
      })
    },
    generateWeeksCanvas (pass, res, name) {
      let pow = Math.pow(10, Math.floor(Math.max.apply(Math, pass) / 5).toString().length - 1)
      let stepsize = Math.round(Math.floor(Math.max.apply(Math, pass) / 5) / pow) * pow
      let formatted = []
      let labels = []
      Object.keys(res).forEach(val => {
        var year = val.substring(0, 4)
        var month = val.substring(4, 6)
        var day = val.substring(6, 8)

        formatted.push(new Date(year, month - 1, day).toLocaleDateString('en-US', {
          weekday: 'short',
          day: 'numeric',
          month: 'short'
        }))
      })
      // formatted[i+7].substring(formatted[i+7].length-2,formatted[i+7].length
      for (let i = 0; i < 7; i++) {
        labels.push(formatted[i] + ' vs ' + formatted[i + 7])
      }
      var labels2 = labels
      if(this.weekChart !=null){
        this.weekChart.destroy();
      }
      var ctx = document.getElementById(name)
      this.weekChart = new Chart(ctx, {
        type: 'line',
        data: {
          datasets: [{
            data: pass.slice(0, 7),
            fill: false,
            label: 'Keçən Həftə',
            borderDash: [10, 5],
            backgroundColor: '#4e73df',
            borderColor: '#4e73df'

          }, {
            data: pass.slice(7, 14),
            fill: false,
            label: 'Bu Həftə',
            backgroundColor: '#4e73df',
            borderColor: '#4e73df'
          }],
          labels: labels.map(a => {
            return a.substring(a.length - 2, a.length)
          })
        },
        options: {
          responsive: true,
          // maintainAspectRatio: false,
          tooltips: {
            mode: 'x',
            intersect: false,
            // axis: 'y',
            callbacks: {
              label: function (tooltipItem, data) {
                if (tooltipItem.datasetIndex == 1) {
                  return tooltipItem.value + ' İstifadəçi (' + Math.max(Math.floor(parseInt(pass[tooltipItem.index + 7]) / parseInt(pass[tooltipItem.index]) * 100 - 100),
                    Math.floor(100 - parseInt(pass[tooltipItem.index + 7]) / parseInt(pass[tooltipItem.index]) * 100)) + '%)'
                }

              },
              title: function (tooltipItem, data) {
                return labels2[tooltipItem[0].index]
              },
              labelTextColor: function (tooltipItem, chart) {
                // console.log(tooltipItem)
                if (parseInt(pass[tooltipItem.index]) >= parseInt(pass[tooltipItem.index + 7])) {
                  return '#ff0000'
                } else {
                  return '#68f802'
                }
              }

            }
          },
          scales: {
            yAxes: [{
              ticks: {
                stepSize: stepsize,
              }
            }]
          }
        }
      })
    }
  },
  mounted () {
    this.id = this.$route.params.id
    console.log(this.id)
    this.getCard(this.id).then(res => {
      console.log(res)
      this.card = res.data.data
      this.getCats(this.card.gid)
      this.bringUStats(this.card.gid)
    })

  },
  beforeRouteUpdate (to, from, next) {
    this.id = to.params.id
    console.log( this.id )
    this.getCard(this.id).then(res => {
      console.log(res)
      this.card = res.data.data
      this.getCats(this.card.gid)
      this.bringUStats(this.card.gid)
    })
    next()
  }
}
</script>
<style scoped>
.box {
  width: 0.5rem;
  height: 0.5rem;
  margin-left: 0.5rem;
  margin-bottom: 0;
}

.green {
  background: #1cc88a;
}

.yellow {
  background: #f6c23e;
}

.red {
  background: #e74a3b;
}
</style>
