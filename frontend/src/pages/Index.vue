<template>
  <q-page class="q-ma-md ">
    <div class="row q-col-gutter-sm">
      <div class="col-3" v-for="(card , index) in cards" :key="index">
        <report-card :report="reportResult[index]" :realtime="realtimeResult[index]" :info="info[index]"/>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import ReportCard from '../components/ReportCard.vue'
import { mapActions } from 'vuex'

export default defineComponent({
  name: 'PageIndex',
  components: { ReportCard },
  data () {
    return {
      reportResult: [],
      realtimeResult: [],
      info: [],
      cards: [67293838, 215310605, 202089847, 192653904]
    }
  },
  methods: {
    ...mapActions('report', ['getReport']),
    ...mapActions('realtime', ['getRealtime']),
    // testFunc() {
    //   for (var i = 0; i < 4; i++) {
    //     this.getRealtime(this.cards[i]).then(res => {
    //       this.realtimeResult.push(res.data.report.reports[0].data.totals[0].values)
    //       this.real.push(res.data.realtime.rows[0])
    //
    //       console.log(this.realtimeResult)
    //     })
    //   }
    //   this.reportResult = []
    //   this.real = []
    // },
    realFunc () {
      for (var i = 0; i < 4; i++) {
        this.getRealtime(this.cards[i]).then(res => {
          // console.log(res.data.data.rows)
          if (this.realtimeResult.length === 4) {
            this.realtimeResult.shift()
            this.realtimeResult.push(res.data.data.rows[0])
          }
          else {
            this.realtimeResult.push(res.data.data.rows[0])
          }
          // console.log(this.realtimeResult)
          console.log(this.realtimeResult)
        })
      }
    },
    reportFunc () {
      for (let i = 0; i < 4; i++) {
        this.getReport(this.cards[i]).then(res => {
          this.reportResult.push(res.data.reports[0].data.totals[0].values)
          this.info.push(res.info[0])
          // console.log(typeof this.reportResult)
          // console.log(res.data.reports[0].data.totals[0])
          // console.log(res.info[0])
        })
      }
    }
  },
  mounted () {
    this.realFunc()
    setInterval(this.realFunc, 20000)
    // this.realFunc()
    this.reportFunc()
  }
})
</script>
