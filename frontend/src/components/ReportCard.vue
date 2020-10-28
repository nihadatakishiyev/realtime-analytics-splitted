<template>
  <div>
    <q-card class="my-card" style="border-left: solid red 4px">
      <q-card-section>
        <q-btn flat color="primary" label="Egov" class="q-mr-sm" to="/egov"/>
        <q-avatar>
          <img src="https://cdn.quasar.dev/img/avatar.png">
        </q-avatar>
      </q-card-section>
      <q-card-section>
        <div class="row reportCardCellView">
          <div class="col-6 reportCardCell hoverable q-mr-2 q-pa-1">
            <div class="text-xs text-weight-bold text-green-13 text-uppercase q-mb-1">Aktiv İstifadəçilər</div>
            <div id="1" class="text-h5 q-mb-0 text-weight-bold text-blue-grey-8">
              <q-skeleton type="text" v-if="getValueOf(0)"/>
              <span v-if="!getValueOf(0)"> {{ realtime[0] }}</span>
              </i>
            </div>
          </div>
          <div class="col-6 reportCardCell hoverable q-mr-2 q-pa-1">
            <div class="text-xs text-weight-bold text-green-13 text-uppercase q-mb-1">İstifadəçilər</div>
            <div id="2" class="text-h5 q-mb-0 text-weight-bold text-blue-grey-8">
              <q-skeleton type="text" v-if="getValueOf(0)"/>
              <span v-if="!getValueOf(0)"> {{ report[0] }}</span>
              </i>
            </div>
          </div>
          <div class="col-6 reportCardCell hoverable q-mr-2 q-pa-1">
            <div class="text-xs text-weight-bold text-green-13 text-uppercase q-mb-1">Sessiyalar</div>
            <div id="3" class="text-h5 q-mb-0 text-weight-bold text-blue-grey-8">
              <q-skeleton type="text" v-if="getValueOf(1)"/>
              <span v-if="!getValueOf(1)">  {{ report[1] }}</span>
              &nbsp;</i></div>
          </div>
          <div class="col-6 reportCardCell hoverable q-mr-2 q-pa-1">
            <div class="text-xs text-weight-bold text-green-13 text-uppercase q-mb-1">Bounce Rate</div>
            <div id="4" class="text-h5 q-mb-0 text-weight-bold text-blue-grey-8">
              <q-skeleton type="text" v-if="getValueOf(2)"/>
              <span v-if="!getValueOf(2)">  {{ getPercentage(report[2]) }}</span>
              &nbsp;</i></div>
          </div>
        </div>
      </q-card-section>
      <q-card-section class="bg-grey-3 q-mb-0">
        Son 7 Gun
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
export default {
  name: 'ReportCard',
  props: ['report', 'realtime'],
  data () {
    return {}
  },
  methods: {
    getValueOf (val) {
      return this.report === undefined ? true : false
    },
    getPercentage (val) {
      return Math.round(parseFloat(val)) + '%'
    }
  }
}
</script>
<style>
.hoverable {
  transition: 0.5s;
}

.hoverable:hover {
  border-top: 2px solid #2E55C7;
  border-radius: 4px;
  background-color: #ece7e7;
  cursor: pointer;
}
</style>
