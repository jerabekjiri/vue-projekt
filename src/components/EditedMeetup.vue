<template>
  <div  v-if="isEditable">
<md-card class="meetup">
  <md-card-media-cover md-solid>
    <md-card-media>
      <img src="../assets/card-default.jpg">
      <md-button class="md-fab md-plain edit-btn" @click="cancelEdit(meetup.url)">
        <md-icon>edit</md-icon>
      </md-button>

    </md-card-media>

    <md-card-area>
      <md-card-header>
        <span class="md-title">{{ meetup.title }}

        <md-button @click="editTitle()" class="md-icon-button md-raised md-primary">
          <md-icon>edit</md-icon>
        </md-button>

       </span>



        <span class="md-subhead">Location: {{ meetup.location }}

          <md-button @click="editLocation()" class="md-icon-button md-raised md-primary">
            <md-icon>edit</md-icon>
          </md-button>

        </span>
      </md-card-header>

    </md-card-area>
  </md-card-media-cover>
</md-card>

<md-card class="tabs-content">

      <md-card-content>
        <md-tabs>
              <md-tab md-label="Information"></md-tab>
        </md-tabs>

        <div>

        {{ meetup.information }}

        <md-button @click="editInfo()" class="md-icon-button md-raised md-primary">
            <md-icon>edit</md-icon>
        </md-button>

      </div>
      </md-card-content>
    </md-card>


    <md-dialog-prompt
    :md-active.sync="active"
    v-model="dialog.value"
    :md-title="dialog.title"
    :md-input-placeholder="dialog.placeholder"
    md-confirm-text="Done"
    @md-confirm="confirm()"
    />





  </div>
</template>

<script>
import API from '../api/meetups';
export default {
  computed: {
    meetup()
    {
      return this.$store.getters.meetup;
    }
  },
  data()
  {
    return {
      active: false,
      editingInfo: false,
      dialog: {
        title: null,
        placeholder: null,
        value: null,
        type: null
      },
      isEditable: false
    }
  },
  created()
  {
      this.$store.dispatch('GET_MEETUP', this.$route.params.url).then(resp => {

        const userId = this.$store.getters.loggedUser.user_id;
        const author = resp.data.author_id;

        if(userId != author)
        {

          this.$router.push('/meetup/' + this.meetup.url);
        }
        else {
          this.isEditable = true;
        }

      });


  },
  methods: {
    cancelEdit(url)
    {
      this.$router.push('/meetup/' + url);
    },
    setDialogProperty(title, placeholder, value, type)
    {
      this.dialog.title = title;
      this.dialog.placeholder = placeholder;
      this.dialog.value = value;
      this.dialog.type = type;
      this.active = true;
    },
    editLocation()
    {
      this.setDialogProperty('Meetup location', 'Type location of meetup', this.meetup.location, 'location');
    },
    editInfo()
    {
      this.setDialogProperty('Meetup Information', 'Type Information about meetup', this.meetup.information, 'information');
    },
    editTitle()
    {
      this.setDialogProperty('Meetup Title', 'Type title of meetup', this.meetup.title, 'title');
    },
    confirm()
    {
      this.dialog.meetup_id = this.meetup.meetup_id;

      let type = this.dialog.type;

      API.editMeetup(this.dialog).then( resp => {
        this.meetup[type] = this.dialog.value;
      });
    }
  }
}
</script>

<style scoped>

.btn-actions{
  top: 70px;
  left: 101%;
}

textarea{
  height: 400px;
}
</style>
