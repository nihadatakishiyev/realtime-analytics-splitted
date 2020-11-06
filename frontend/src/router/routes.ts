import { RouteConfig } from 'vue-router'
import EssentialLink from "components/EssentialLink.vue"
import ReportCard from "components/ReportCard.vue"
import Egov from "pages/Egov.vue"
import AnalyticsView from "components/AnalyticsView.vue"

const routes: RouteConfig[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  },
  {
    path: '/analytics/egov',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: Egov }
    ]

  }
]

export default routes
