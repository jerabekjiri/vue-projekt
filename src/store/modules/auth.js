import API from '../../api/auth'
import axios from 'axios'

  const state = {
    token: localStorage.getItem('user-token') || '',
    status: '',
    loggedUser: {}
  }

  const getters = {
    isAuthenticated: state => !!state.token,
    authStatus: state => state.status,
    loggedUser: state => state.loggedUser
  }

 const mutations = {
          AUTH_REQUEST(state) {
            state.status = 'loading'
          },
          AUTH_SUCCESS(state, token) {
            state.status = 'success'
            state.token = token
          },
          AUTH_ERROR(state) {
            state.status = 'error'
          },
          AUTH_LOGOUT(state) {
            state.token = ''
          },
          SIGNIN_USER(state, user)
          {
            state.loggedUser = user;
            if(state.loggedUser.avatar != '')
            {
            state.loggedUser = 'http://localhost:4040/img/avatars/' + state.loggedUser.avatar;

            }
          }
       }


  const actions = {

    AUTH_REQUEST({commit, dispatch}, user) {
       return new Promise((resolve, reject) => {
         commit('AUTH_REQUEST')
            axios({url: 'http://localhost:4040/api/auth', data: user, method: 'POST' }).then(resp => {
             const token = resp.data.token;
             localStorage.setItem('user-token', token); // store the token in localstorage
             axios.defaults.headers.common['Authorization'] = "Bearer " + token;
            commit('AUTH_SUCCESS', token)

             dispatch('SIGNIN_USER', token);
             resolve(resp)
           })
         .catch(err => {
           commit('AUTH_ERROR', err)
           localStorage.removeItem('user-token')
          delete axios.defaults.headers.common['Authorization']
           reject(err)
         })
       })
    },

    AUTH_LOGOUT({commit, dispatch}, user) {
      return new Promise((resolve, reject) => {
        commit('AUTH_LOGOUT')
        localStorage.removeItem('user-token');
        //localStorage.removeItem('user'); // clear your user's token from localstorage
        resolve()
    })
  },

  AUTH_SIGNUP({ commit, dispatch }, user) {
    return new Promise((resolve, reject) => {
      commit('AUTH_REQUEST');
      axios({url: 'http://localhost:4040/api/auth/signup', data: user, method: 'POST' }).then(resp => {
       const token = resp.data.token;
       localStorage.setItem('user-token', token); // store the token in localstorage

       axios.defaults.headers.common['Authorization'] = "Bearer " + token;
      commit('AUTH_SUCCESS', token);

       dispatch('SIGNIN_USER', token);
       resolve(resp)
     })
   .catch(err => {
     commit('AUTH_ERROR', err)
          // if the request fails, remove user token if exists
    localStorage.removeItem('user-token')

    delete axios.defaults.headers.common['Authorization']
     reject(err)
   })
  })
},

  SIGNIN_USER({ commit, dispatch }, token)
  {
      axios({url: 'http://localhost:4040/api/auth/signin', data: { token }, method: 'POST' }).then(resp => {
        commit('SIGNIN_USER', resp.data);


        /*
         * TODO, only for testing purpose
         */
        dispatch('SET_JOINED_MEETUPS', resp.data);

        dispatch('SET_ORGANIZED_MEETUPS', resp.data);

      });
  },

  SIGNUP_USER({ commit, dispatch }, user)
  {
      axios({url: 'http://localhost:4040/api/auth/signup', data: { user }, method: 'POST' }).then(resp => {
        commit('SIGNIN_USER', resp.data);
      });
  }


}


export default { state, mutations, getters, actions }
