<template>
  <div>
     <md-button class="md-raised md-primary" @click="toggleComment = true" v-if="!toggleComment"><md-icon>comment</md-icon> Comment</md-button>

     <md-card class="discussion md-primary" v-if="toggleComment">

       <md-card-header>

       <md-avatar>
         <img src="../../assets/avatar-default.jpg">
       </md-avatar>
         <div class="md-title">{{ user.name }}</div>
       </md-card-header>

       <md-card-content>
         <md-field>
           <label>Write a comment</label>
           <md-textarea v-model="comment.comment"></md-textarea>
        </md-field>
       </md-card-content>

       <md-card-actions>
         <md-button @click="toggleComment = false">cancel</md-button>
         <md-button @click="send()">send</md-button>
       </md-card-actions>

     </md-card>

     <md-snackbar :md-active.sync="showSnackbar" md-persistent  :md-position="'center'">
         <span class="upper">Comment posted</span>
       <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
     </md-snackbar>
  </div>

</template>

<script>
export default {
  methods: {
    send()
    {
      this.comment.meetup_id = this.$store.getters.meetup.meetup_id;
      this.comment.user_id = this.user.user_id;
      this.comment.avatar = this.user.avatar;
      this.comment.name = this.user.name;
      this.$store.dispatch('ADD_COMMENT', this.comment).then( response => {
        this.showSnackbar = true;
        this.toggleComment = false;
        this.comment = {};
      });
    }
  },
  computed: {
      user()
      {
          return this.$store.getters.loggedUser;
      }
  },
  data()
  {
    return {
      comment: {},
      showSnackbar: false,
      toggleComment: false
    }
  },
  created()
  {
  }
}
</script>

<style scoped>
  .md-card{
    background: #448affb5!important;
  }

  .md-card-content{
    padding-top: 10px !important;
  }

  .md-textarea{
    -webkit-text-fill-color: white !important;
  }
</style>
