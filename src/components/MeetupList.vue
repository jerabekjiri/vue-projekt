<template>
  <div>

<div v-if="meetups.length > 0">

    <md-card v-for="meetup in meetups" :key="meetup.id" class="meetup md-primary">
      <md-card-media-cover md-solid>
        <md-card-media>
        <!--  <img v-if="meetup.img" :src="meetup.img">-->
        <img src="../assets/card-default.jpg">
        </md-card-media>

        <md-card-area>
          <md-card-header>
            <span class="md-title">{{ meetup.title }}</span>
            <span class="md-subhead">{{ meetup.date | parseDate }}</span>
            <span class="md-subhead">Location: {{ meetup.location }}</span>
            <span v-if="meetup.members > 0"class="md-subhead">Members: {{ meetup.members }}</span>
            <span v-else class="md-subhead">No members coming to this meetup at moment</span>
          </md-card-header>

          <md-card-actions>
            <md-button :to="'/meetup/' + meetup.url">Meet us</md-button>
          </md-card-actions>
        </md-card-area>
      </md-card-media-cover>
    </md-card>

  </div>
  <div class="spinner" v-else>
      <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
    </div>
  </div>
</template>

<script>
import API from '../api/meetups';
import Utils from './Utils/Utils';
export default {
  data()
  {
    return {
      isLoaded: false
    }
  },
  computed: {
    meetups()
    {
      return this.$store.state.MeetupsModule.meetups;
    }
  },
  methods: {
    },
    created()
    {
      this.$store.dispatch('getMeetups');
/*
      API.getImage('kuba').then( response =>{
        var reader = new window.FileReader();
        reader.readAsDataURL(response.data);
        reader.onload = function() {

            var imageDataUrl = reader.result;

            setTimeout(()=>{
              console.log(this.meetups[0]);
            },500)
          }
      });*/
    },
    mixins: [Utils]
}
</script>

<style scoped>
  .md-card-header-text div{
      margin-bottom: 10px;
  }

  .md-content {
    width: 100%;
    height: 200px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
  }

  .tabs-content{
    margin-top: 25px;
  }

  .meetup{
    margin-bottom: 15px;
  }

  .spinner {
    text-align: center;
  }

</style>
