<template>
  <q-page class="q-ma-md ">
    <div class="row q-col-gutter-sm">
      <div class="col-3" v-for="(card , index) in cards" :key="index">
        <report-card :report="reports[index]"/>
      </div>
    </div>

  </q-page>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import ReportCard from '../components/ReportCard.vue'
import {mapActions} from 'vuex'

export default defineComponent({
  name: 'PageIndex',
  components: { ReportCard },
  data() {
    return {
      reports: [],
      cards: [67293838, 215310605, 202089847, 192653904]
    }
  },
  methods: {
    ...mapActions('report', ['getReport'])
  },
  mounted() {
    for (var i = 0; i < 4; i++) {
      this.getReport(this.cards[i]).then(res => {
        console.log(res.data.reports[0].data.totals[0].values)
        this.reports.push(res.data.reports[0].data.totals[0].values)
      })
    }

  }
})
</script>
