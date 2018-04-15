<template>
  <div>

 <md-progress-bar  v-if="members.length <= 0 && stopLoading == false" md-mode="indeterminate"></md-progress-bar>

<md-list v-else>
<md-list-item v-for="member in members" :key="member.id">
  <md-avatar>
    <md-icon class="md-size-2x">face</md-icon>
  </md-avatar>

  <span class="md-list-item-text">{{ member.name }}</span>

  <md-button class="md-icon-button md-list-action" :to="'/user/' + member.href">
    <md-icon>directions</md-icon>
  </md-button>
</md-list-item>
</md-list>

<div v-if="stopLoading && members.length <= 0" class="info-msg">
  Nobody is coming to this meetup
</div>


  </div>
</template>

<script>
export default {
  data()
  {
    return {
      stopLoading: false
    }
  },
  created()
  {
    let url = this.$route.params.url;
      this.$store.dispatch('GET_MEMBERS', url).then(() => {
        this.stopLoading = true;
      });

  },
  computed: {
    members()
    {
      return this.$store.getters.members;
    }
  }

}
</script>

<style scoped>

.md-progress-bar{
  margin-top: 10px;
}

.info-msg{
  text-align: center;
}
</style>
