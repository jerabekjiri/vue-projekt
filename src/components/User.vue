<template>
  <div>

    <md-card>
      <md-card-header>
        <md-card-header-text>
          <div class="md-title">{{ user.name }}</div>
          <div class="md-subhead">{{ user.information }}</div>
        </md-card-header-text>

        <md-card-media>
        <!--  <img src="../assets/avatar-default.jpg" alt="Avatar" class="rounded-img">-->
          <img :src="user.avatar" alt="Avatar" class="rounded-img">
        </md-card-media>
      </md-card-header>

      <md-card-actions v-if="!isSignedIn">
          <md-button>Follow</md-button>
      </md-card-actions>
    </md-card>

    <md-card class="users-meetups" v-if="isSignedIn">
      <md-card-header>
        <md-card-header-text>
          <div class="md-title">{{ user.name }}'s meetups </div>
        </md-card-header-text>
      </md-card-header>
      <md-card-content>

        <md-progress-bar v-if="meetups.length <= 0" md-mode="indeterminate"></md-progress-bar>

        <md-list>
          <md-list-item v-for="meetup in meetups" :key="meetup.id">

            <div class="md-list-item-text">
              <span>{{ meetup.title }}</span>
              <span>{{ meetup.location }}</span>
              <p>{{ meetup.date }}</p>
            </div>

            <md-button class="md-icon-button md-list-action">
              <md-icon class="md-primary">star</md-icon>
            </md-button>
          </md-list-item>
        </md-list>

      </md-card-content>
    </md-card>




  </div>

</template>

<script>
export default {
  computed: {
    meetups()
    {
      return this.$store.getters.usersMeetups;
    },
    isSignedIn()
    {
      return this.$store.state.AuthModule.isSignedIn;
    },
    user()
    {
      return this.$store.state.UsersModule.user;
    }
  },
  created()
  {
    let name = this.$route.params.name;

      this.$store.dispatch('getUser', name);


  },
  methods: {
    path(img)
    {
     return require('../assets/avatar.jpg');
    }
  }
}
</script>

<style scoped>
.users-meetups{
    margin-top: 15px;
}

</style>
