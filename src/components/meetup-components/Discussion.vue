<template>
  <div>
    <NewComment v-if="isSignedIn"></NewComment>

    <md-card v-for="comment in discussion" class="discussion md-primary" :key="discussion.id">

      <md-card-header>

      <md-avatar>
        <img src="../../assets/avatar-default.jpg">
      </md-avatar>

        <div class="md-title">{{ comment.name }}</div>
        <div class="md-subhead">Date</div>

      </md-card-header>

      <md-card-content>
        {{ comment.comment }}
      </md-card-content>

      <md-card-actions>
              <md-button class="md-icon-button">
                <md-icon>favorite</md-icon>
              </md-button>
      </md-card-actions>

    </md-card>
  </div>
</template>

<script>
import NewComment from './NewComment';
export default {
  components: {
    NewComment
  },
  computed: {
    isSignedIn()
    {
      return this.$store.getters.isAuthenticated;
    },
    discussion() {
      return this.$store.getters.discussion;
    }
  },
  created()
  {
    let url = this.$route.params.url;
    this.$store.dispatch('SET_DISCUSSION', url);
  }
}
</script>

<style scoped>
  .discussion{
    margin-top: 15px;
  }

  .discussion .md-card-content{
    height: auto;
  }

  .answer{
    margin-left: 50px;
  }
</style>
