import Vue        from 'vue'
import Router     from 'vue-router'
import store from '../store' // your vuex store

const Home            = () => import('@/components/Home');
const Meetup          = () => import('@/components/Meetup');
const Information     = () => import('@/components/meetup-components/Information');
const Discussion      = () => import('@/components/meetup-components/Discussion');
const Members         = () => import('@/components/meetup-components/Members');
const MeetupList      = () => import('@/components/MeetupList');
const Profile         = () => import('@/components/Profile');
const SignIn          = () => import('@/components/SignIn');
const SignUp          = () => import('@/components/SignUp');
const ProfileSettings = () => import('@/components/ProfileSettings');
const User            = () => import('@/components/User');
const EditedMeetup    = () => import('@/components/EditedMeetup');

Vue.use(Router)




const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next()
    return
  }
  next('/profile')
}

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next()
    return
  }
  next('/signin')
}

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home
    },
    {
      path: '/home',
      component: Home
    },
    {
      path: '/meetups',
      component: MeetupList
    },
    {
      path: '/profile',
      component: Profile,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/profile-settings',
      component: ProfileSettings,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/signin',
      component: SignIn,
      beforeEnter: ifNotAuthenticated
    },
    {
      path: '/signup',
      component: SignUp,
      beforeEnter: ifNotAuthenticated
    },
    {
      path: '/user/:name',
      component: User
    },
    {
      path: '/meetup/:url/',
      component: Meetup,
      children: [
        {
          path: '/',
          component: Information
        },
        {
          path: 'info',
          component: Information
        },
        {
        path: 'discussion',
        component: Discussion
      },
      {
        path: 'members',
        component: Members
      }]
    },
    {
      path: '/meetup/:url/edited',
      component: EditedMeetup,
      beforeEnter: ifAuthenticated
    }
  ]
})
