<template>
  <q-page class="q-ma-md ">
    <div class="row q-col-gutter-sm">
      <div class="col-3" v-for="(card , index) in cards" :key="'ga:' +card">
        <report-card :report="reportResult['ga:' +card]" :realtime="realtimeResult['ga:' +card]" :info="info['ga:' +card]"/>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import {defineComponent, set} from '@vue/composition-api'
import ReportCard from '../components/ReportCard.vue'
import { mapActions } from 'vuex'
import Vue from 'vue'
export default defineComponent({
  name: 'PageIndex',
  components: { ReportCard },
  data () {
    return {
      reportResult: [],
      realtimeResult: [],
      info: [],
      dataInterval: null,
      cards: [67293838, 215310605, 202089847, 192653904]
    }
  },
  methods: {
    ...mapActions('report', ['getReport']),
    ...mapActions('realtime', ['getRealtime']),
    realFunc () {
      this.cards.map(a => {
        this.getRealtime(a).then(res => {
          // console.log(res.data.data.rows)
          this.realtimeResult['ga:' + a] = res.data.data.rows[0]

          console.log(res)
          this.$forceUpdate()

        })
      })
    },
    reportFunc () {
      this.cards.map((a, index) => {
        this.getReport(a).then(res => {

          // this.set(this.reportResult, 'ga:'+a, res.data.reports[0].data.totals[0].values)
          this.reportResult['ga:'+a] =res.data.reports[0].data.totals[0].values
          console.log(this.reportResult)

          this.info['ga:'+a] = res.info[0]
          this.$forceUpdate()
        })
      })
      // for (let i = 0; i < 4; i++) {
      //   var id =this.cards[i]
      //
      // }
    }
  },
  mounted () {
    this.reportFunc()
    this.realFunc()
    this.dataInterval = setInterval(() => {
      this.realFunc()
      if (this.dataInterval != null){
        this.dataInterval = null
      }
    }, 20000)
  }
})
</script>
