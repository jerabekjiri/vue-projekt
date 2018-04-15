import Vue from 'vue'
import Vuex from 'vuex'
import API from '../api/meetups'
import AuthModule from './modules/auth'
import MeetupsModule from './modules/meetups'
import UsersModule from './modules/users'

Vue.use(Vuex)


export default new Vuex.Store({
  modules: {
    AuthModule,
    MeetupsModule,
    UsersModule
  }
})
