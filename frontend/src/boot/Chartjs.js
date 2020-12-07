// import something here
import Chart from 'chart.js'

// "async" is optional;
// more info on params: https://quasar.dev/quasar-cli/cli-documentation/boot-files#Anatomy-of-a-boot-file
export default async ( { app, router, Vue} ) => {
  // something to do
  app.Chart = Chart
}
