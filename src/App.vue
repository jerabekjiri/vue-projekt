<template>
  <div class="page-container">
    <md-app md-mode="reveal">
      <md-app-toolbar class="md-primary">
        <md-button class="md-icon-button" @click="menuVisible = !menuVisible" v-if="isSignedIn">
          <md-icon>menu</md-icon>
        </md-button>
        <router-link to="/meetups">
          <md-button class="btn-title md-dense md-primary">Browse meetups</md-button>
        </router-link>

          <div class="md-toolbar-section-end">
          <md-button @click="showDialog = true" v-if="isSignedIn">
              <span>Create a Meetup</span>
          </md-button>

            <md-button to="/profile" v-if="isSignedIn">
              <md-avatar>
                <img v-if="user.avatar" :src="user.avatar" alt="Avatar">
                <img v-else src="./assets/avatar-default.jpg" alt="Avatar">
              </md-avatar>
              <span>{{ user.name }}</span>
          </md-button>


        <div v-else>
          <md-button to="/signin">
            <md-icon>perm_identity</md-icon>
            <span>Sign In</span>
        </md-button>
    </div>

        </div>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible">
        <md-toolbar class="md-transparent" md-elevation="0">Navigation</md-toolbar>

        <md-list>
          <router-link to="/profile">
            <md-list-item>
              <md-icon>dashboard</md-icon>
              <span class="md-list-item-text" @click="close()">Dashboard</span>
            </md-list-item>
          </router-link>

          <router-link :to="'/meetups'">
            <md-list-item>
              <md-icon>today</md-icon>
              <span class="md-list-item-text"  @click="close()">Meetups</span>
            </md-list-item>
          </router-link>

          <md-list-item>
            <md-icon>people</md-icon>
            <span class="md-list-item-text">Friends</span>
          </md-list-item>

          <md-list-item v-if="isSignedIn">
            <md-icon>exit_to_app</md-icon>
            <span class="md-list-item-text" @click="logout()">Logout</span>
          </md-list-item>
        </md-list>
      </md-app-drawer>

      <md-app-content>
       <!--<transition name="fade">-->
        <router-view></router-view>
      <!--</transition>-->
      </md-app-content>
    </md-app>

  <CreateMeetup :dialog="showDialog" v-on:close="showDialog = false"></CreateMeetup>

  </div>
</template>

<script>
import axios from 'axios';
import CreateMeetup from './components/CreateMeetup';
export default {
  components: {
    CreateMeetup
  },
  computed: {
    user()
    {
      return this.$store.getters.loggedUser;
    },
    isSignedIn()
    {
      return this.$store.getters.isAuthenticated;
    }
  },
  data()
  {
    return{
      menuVisible: false,
      showDialog: false
    }
  },
  methods: {
    close()
    {
      this.menuVisible = false;
    },
    logout()
    {
      this.$store.dispatch('AUTH_LOGOUT').then(() => {
        this.$router.push('/signin');
      });
    },
    checkToken()
    {
      const token = localStorage.getItem('user-token');
      if (token)
      {
        axios.defaults.headers.common['Authorization'] = "Bearer " + token;
        this.$store.dispatch('SIGNIN_USER', token);
        
      }
    }
  },
  created()
  {
    this.checkToken();
  }
}
</script>



<style>

  html, body
  {
    height: 100%;
  }

  .page-container{
    height: inherit;
  }

  .edit-btn{
      position: absolute;
      left: 100%;
      top: 0;
  }

  .md-app {
    border: 1px solid rgba(#000, .12);
    height: 100%;
  }

   // Demo purposes only
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }

  .md-app-content{
    width: 800px;
    margin: 0px auto;
  }

  main, .md-content {
    background: #f5f5f5 !important;
  }

  ::selection {
  background: #86b3ff !important; /* WebKit/Blink Browsers */
}

.dialog{
  width: 50%;
}

/*
 * Router's fader
 */
.fade-enter-active, .fade-leave-active {
  transition-property: opacity;
  transition-duration: .25s;
}

.fade-enter-active {
  transition-delay: .25s;
}

.fade-enter, .fade-leave-active {
  opacity: 0
}

.rounded-img {
  border-radius: 50%;
}

.btn-title{
  font-size: 19px !important;
}

.upper{
  text-transform: uppercase;
}

</style>
