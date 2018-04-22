import axios from 'axios';

  var url = `http://localhost:4040/api`;

export default {

  getMeetups()
  {
    return axios.get(url + '/meetups');
  },

  getMeetup(meetup)
  {
    //return axios.get(url + `/meetup/${meetup}`);
    return this.getMeetupProtected(meetup, 10);
  },

  getMeetupProtected(meetup, userId)
  {
    return axios.get(url + `/meetup/${meetup}/user/${userId}`);
  },

  getJoinedMeetups(user)
  {
    return axios.get(url + `/user/${user.user_id}/users-meetups`);
  },

  getMembers(meetupUrl)
  {
    return axios.get(url + `/meetup/${meetupUrl}/members`);
  },

  joinMeetup(meetup, user)
  {
    return axios.post(`http://localhost:4040/api/meetup/join`, { meetup_id: meetup, user_id: user});
  },

  unjoinMeetup(meetup, user)
  {
    return axios.post(`http://localhost:4040/api/meetup/unjoin`, { meetup_id: meetup, user_id: user});
  },

  getDiscussion(meetupUrl)
  {
    return axios.get(url + `/meetup/${meetupUrl}/discussion`);
  },

  addComment(comment)
  {
    return axios.post(url + `/meetup/add-comment`, comment);
  },

  createMeetup(meetup)
  {
    return axios.post(url + `/meetup/create`, meetup);
  },

  getImage(path)
  {
    return axios.get(url + '/img/banners/background1', { responseType: 'arraybuffer'  });

  },

  getOrganizedMeetups(userId)
  {
    return axios.get(url + `/user/${userId}/organized-meetups`);
  },

  editMeetup(meetup)
  {
    return axios.post(url + `/meetup/edit`, meetup);
  }

}
