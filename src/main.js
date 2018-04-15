import Vue             from 'vue'
import App             from './App'
import router          from './router'
import Vuex            from 'vuex'
import VueMaterial     from 'vue-material'
import store           from './store/index'
import VueLocalStorage from 'vue-localstorage'
import VueJWT          from 'vuejs-jwt'

Vue.config.productionTip = false

/*
 * TODO VueMaterial import by module, not whole, performance issue
 */

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'

Vue.use(VueMaterial)
Vue.use(Vuex)
Vue.use(VueLocalStorage)
Vue.use(VueJWT)


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
