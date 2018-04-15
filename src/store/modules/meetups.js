import API from '../../api/meetups'

const state = {
  meetups: [],
  meetup: {},
  joinedMeetups: [],
  discussion: [],
  editedMeetup: {}
}

const getters = {
    joinedMeetups: state => state.joinedMeetups,
    meetup: state => state.meetup,
    discussion: state => state.discussion
}

const mutations = {
   SET_MEETUPS(state, meetups) {
      state.meetups = meetups;
  },

  SET_MEETUP(state, meetup) {
      state.meetup = meetup;
  },

  SET_JOINED_MEETUPS(state, meetups)
  {
    state.joinedMeetups = meetups;
  },

  JOIN_MEETUP(state, meetup, user)
  {
    state.meetup.joined = 1;
  },

  UNJOIN_MEETUP(state, meetup)
  {
    state.meetup.joined = 0;
  },

  SET_MEMBERS(state, joinedMeetups)
  {
    state.joinedMeetups = joinedMeetups;
  },

  ADD_MEMBER(state, user)
  {
    state.joinedMeetups.push(user);

    //add to member count
    state.meetup.members++;

  },

  REMOVE_MEMBER(state, user)
  {
    state.joinedMeetups = state.joinedMeetups.filter( users => users.user_id != user.user_id);

    //remove from member count
    state.meetup.members--;
  },

  SET_DISCUSSION(state, discussion)
  {
    state.discussion = discussion;
  },

  ADD_COMMENT(state, comment)
  {
    state.discussion.unshift(comment);
  },

  CREATE_MEETUP(state, meetup)
  {
    state.meetups.unshift(meetup);
  },

  EDITED_MEETUP(state, meetup)
  {
    state.editedMeetup = meetup;
  }
}

const actions = {
  getMeetups({ commit }) {
  API.getMeetups().then(response => {
    commit('SET_MEETUPS', response.data);
  });
  },

  GET_MEETUP({ commit, rootState }, meetup) {
    const userId = rootState.AuthModule.loggedUser.user_id;
    API.getMeetupProtected(meetup, userId).then(response => {
      commit('SET_MEETUP', response.data);
    });
  },

  SET_JOINED_MEETUPS({ commit }, user)
  {
    API.getJoinedMeetups(user).then(response => {
        commit('SET_JOINED_MEETUPS', response.data);
            });
  },

  JOIN_MEETUP({ commit, rootState }, meetup)
  {
    const userId = rootState.AuthModule.loggedUser.user_id;
    const meetupId = meetup.meetup_id;
    const user = rootState.AuthModule.loggedUser;
    API.joinMeetup(meetupId, userId).then( response => {
      commit('JOIN_MEETUP', meetup);
      commit('ADD_MEMBER', user);
  })
},

  UNJOIN_MEETUP({ commit, rootState }, meetup)
  {
    const userId = rootState.AuthModule.loggedUser.user_id;
    const user = rootState.AuthModule.loggedUser;
    const meetupId = meetup.meetup_id;
    API.unjoinMeetup(meetupId, userId).then( response => {
      commit('UNJOIN_MEETUP', meetup);
      commit('REMOVE_MEMBER', user);
    })
},

GET_MEMBERS({ commit}, meetupUrl) {
  return new Promise((resolve, reject) => {

  commit('SET_MEMBERS', []);
  API.getMembers(meetupUrl).then(response => {
    commit('SET_MEMBERS', response.data);
    resolve(response);
});


});
},

SET_DISCUSSION({ commit }, meetupUrl) {
  commit('SET_DISCUSSION', []);
  API.getDiscussion(meetupUrl).then(response => {
    commit('SET_DISCUSSION', response.data);
  });
},

ADD_COMMENT({ commit }, comment) {
  return new Promise( (resolve, reject) => {
    API.addComment(comment).then(response => {
      commit('ADD_COMMENT', comment);
      resolve(response);
    });
  })
},

CREATE_MEETUP({ commit }, meetup)
{
  return new Promise((resolve, reject) => {
    API.createMeetup(meetup).then(response => {
      commit('CREATE_MEETUP', meetup);
      resolve(response);
    });
  })
},

EDITED_MEETUP({ commit }, meetup)
{
  commit('EDITED_MEETUP', meetup);
},

}

export default { state, mutations, actions, getters }
