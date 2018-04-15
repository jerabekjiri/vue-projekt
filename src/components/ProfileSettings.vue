<template>
  <div class="md-layout">

    <div class="md-layout-item  md-size-30">
      <md-card class="avatar ">
          <md-card-content>
           <img :src="user.avatar">
        </md-card-content>
     </md-card>
    </div>

    <div class="md-layout-item">
       <md-card>
         <md-card-header>
           <div class="md-title">{{ user.name }}</div>
         </md-card-header>

         <md-card-content>

             <md-field>
              <label>Upload avatar</label>
              <md-file id="file" v-model="image" accept="image/*" />
            </md-field>
            <md-button @click="upload()" :disabled="!image" >Upload</md-button>

        <md-list class="md-double-line">
         <md-subheader>Contacts</md-subheader>

         <md-list-item v-for="contact in contacts" :key="contact.contact_id">
           <md-icon class="md-primary">{{ contact.icon }}</md-icon>

           <div class="md-list-item-text">
             <span>{{ contact.contact }}</span>
             <span>{{ contact.name }}</span>
           </div>
         </md-list-item>
       </md-list>


         </md-card-content>
       </md-card>
    </div>



</div>
</template>
<script>
import API from '../api/users';
export default {
  data()
  {
    return {
      image: null,
      contacts: null
    }
  },
  computed:
  {
    user()
    {
      return this.$store.getters.loggedUser;
    }
  },
  methods: {
    upload()
    {
      let file = document.getElementById('file').files[0];

      const formData = new FormData();
      formData.append('image', file);

      API.uploadAvatar(formData).then(response => {
        this.user.avatar = 'http://localhost:4040/img/avatars/' + file.name;
      });
    },
    getContacts()
    {
      API.getContacts(10).then(resp => {
        this.contacts = resp.data;
      });
    }

  },
  created()
  {
    this.getContacts();
  }
}
</script>

<style scoped>

.avatar{

}



</style>
