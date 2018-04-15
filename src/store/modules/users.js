import API from '../../api/users'

const state = {
  users: [],
  user: {},
  members: [],
  usersMeetups: []
}

const getters = {
  user: state => state.user,
  usersMeetups: state => state.usersMeetups
}

const mutations = {
  SET_USERS(state)
  {
    API.getUsers().then(response => {
      state.users = response.data;
    });
  },

  SET_USER(state, user)
  {
      state.user = user;
      state.user.avatar = 'http://localhost:4040/img/avatars/' + state.user.avatar;
  },

  SET_USERS_MEETUPS(state, meetups)
  {
    state.usersMeetups = meetups;
  }

}

const actions = {
  getUsers({ commit }) {
    commit('SET_USERS');
  },

  getUser({ commit, dispatch }, name) {
    API.getUser(name).then(response => {

      commit('SET_USER', response.data);
      dispatch('getUsersMeetups', response.data);

    });

  },

  getUsersMeetups({ commit }, user) {

    API.getUsersMeetups(user).then(response => {
        commit('SET_USERS_MEETUPS', response.data);
            });
  }
}

export default { state, mutations, actions, getters }
