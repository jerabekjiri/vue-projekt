import axios from 'axios';

  var url = `http://localhost:4040`;

export default {

  getUsers()
  {
    return axios.get(url + '/users');
  },

  getUser(name)
  {
    return axios.get(url + '/user/' + name);
  },

  getUsersMeetups(user)
  {
    return axios.get(url + `/api/user/${user.user_id}/users-meetups`);
  },

  uploadAvatar(data)
  {
    const config = {
      headers: {
        'content-type': 'multipart/form-data'
      }
    };
    return axios.post(url + `/api/user/upload`, data, config);
  },

  getContacts(id)
  {
    return axios.get(url + `/api/user/${id}/contacts`);
  },

  getContactType()
  {
    return axios.get(url + `/api/contact-type`);
  },

  addContact(contact)
  {
    return axios.post(url + `/api/user/contacts`, contact);
  },

  editContact(contact)
  {
    return axios.post(url + `/api/user/contacts/edit`, contact);
  },

  deleteContact(contact)
  {
    return axios.post(url + `/api/user/contacts/delete`, contact);
  }

}
