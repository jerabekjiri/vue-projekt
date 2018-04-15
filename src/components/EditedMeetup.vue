<template>
  <div>
<md-card class="meetup">
  <md-card-media-cover md-solid>
    <md-card-media>
      <img src="http://localhost:4040/img/avatars/background1.jpg" alt="Skyscraper">

      <md-button class="md-fab md-plain edit-btn" @click="cancelEdit(meetup.url)">
        <md-icon>edit</md-icon>
      </md-button>

      <md-button class="md-raised md-primary  edit-btn btn-actions" @click="saveEdit()">Save</md-button>

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

        <div v-if="!editingInfo">

        {{ meetup.information }}

        <md-button @click="editInfo()" class="md-icon-button md-raised md-primary">
            <md-icon>edit</md-icon>
        </md-button>

      </div>

        <md-field v-else>
          <label>Information</label>
          <md-textarea v-model="meetup.information"></md-textarea>
        </md-field>

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
        value: null
      }
    }
  },
  created()
  {
      this.$store.dispatch('GET_MEETUP', this.$route.params.url);

  },
  methods: {
    cancelEdit(url)
    {
      this.$router.push('/meetup/' + url);
    },
    saveEdit()
    {

    },
    setDialogProperty(title, placeholder, value)
    {
      this.dialog.title = title;
      this.dialog.placeholder = placeholder;
      this.dialog.value = value;
    },
    editLocation()
    {
      this.setDialogProperty('Meetup location', 'Type location of meetup', this.meetup.location);
      this.active = true;
    },
    editInfo()
    {
      this.editingInfo = true;
    },
    editTitle()
    {
      this.setDialogProperty('Meetup Title', 'Type title of meetup', this.meetup.title);
      this.active = true;
    },
    confirm()
    {
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
