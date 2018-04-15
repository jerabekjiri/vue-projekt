import axios from 'axios';

export default {

  authRequest(user)
  {
    //return axios.post('http://localhost:4040/auth/', user, { })
  },

  signIn(user)
  {
    return axios.post(`http://localhost:4040/api/auth/signin`,
                      user,
                      { headers: {'X-Requested-With' : 'XMLHttpRequest'}});

  },

  signUp(user)
  {
    return axios.post(`http://localhost:4040/auth/user/signup`,
                      user,
                      { headers: {'X-Requested-With' : 'XMLHttpRequest'}});
  },

  emailUnique(email)
  {
      return axios.post(`http://localhost:4040/auth/user/signup/email`,
                        email,
                        { headers: {'X-Requested-With' : 'XMLHttpRequest'}});
  }


}
