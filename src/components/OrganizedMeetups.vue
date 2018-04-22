<template>
  <div>
  <md-table v-model="meetups" md-card>
  <md-table-toolbar>
    <h1 class="md-title">Meetups organized by me</h1>
  </md-table-toolbar>

  <md-table-row slot="md-table-row" slot-scope="{ item }">
    <md-table-cell md-label="Title" md-sort-by="title" >{{ item.title }}</md-table-cell>
   <md-table-cell md-label="Date" md-sort-by="date" md-numeric>{{ item.date | parseDate }}</md-table-cell>
    <md-table-cell md-label="Location" md-sort-by="location">{{ item.location }}</md-table-cell>
    <md-table-cell md-label="members" md-sort-by="members" md-numeric>{{ item.members }}</md-table-cell>
      <md-button class="md-primary" :to="'/meetup/' + item.url">MANAGE</md-button>
  </md-table-row>
</md-table>


  </div>
</template>

<script>
import Utils from './Utils/Utils';
export default {
  computed: {
    meetups()
    {
      return this.$store.getters.organizedMeetups;
    }
  },
  mixins: [Utils]
}
</script>

<style scoped>
</style>
