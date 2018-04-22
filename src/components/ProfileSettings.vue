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

           <md-menu>
               <md-button class="md-icon-button" md-menu-trigger>
                 <md-icon>more_horiz</md-icon>
               </md-button>

               <md-menu-content>
                 <md-menu-item @click="dialogEditContact(contact)">
                     <span>Edit</span>
                     <md-icon>edit</md-icon>
                 </md-menu-item>

                 <md-menu-item @click="deleteContact(contact)">
                   <span>Delete</span>
                   <md-icon>delete  </md-icon>
                 </md-menu-item>
               </md-menu-content>
             </md-menu>
         </md-list-item>

         <md-button class="md-raised md-primary" @click="dialogAddContact()">Add contact</md-button>

       </md-list>


         </md-card-content>
       </md-card>

       <md-dialog :md-active.sync="dialog.open">
            <md-dialog-title>ADD CONTACT</md-dialog-title>
            <md-dialog-content>

            <md-field>
               <label for="contacts">Contacts type</label>
               <md-select v-model="form.name" name="contacts">
                 <md-option v-for="type in contactType" :value="type.name" :key="type.contact_type_id">{{ type.name }}</md-option>
               </md-select>
             </md-field>

              <md-field>
                <label>Contact</label>
                <md-input v-model="form.contact"></md-input>
             </md-field>
       </md-dialog-content>

            <md-dialog-actions>
              <md-button class="md-primary" @click="cancelDialog()">Cancel</md-button>

              <md-button v-if="dialog.mode == 'add'" class="md-primary" @click="addContact()">Add to contacts</md-button>
              <md-button v-if="dialog.mode == 'edit'" class="md-primary" @click="editContact()">Edit contact</md-button>

            </md-dialog-actions>
         </md-dialog>


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
      contacts: null,
      dialog: {
        open: false,
        mode: null
      },
      contactType: null,
      movie: null,
      form: {
        contact: null,
        name:null,
        icon: null
      },
      beforeEdit: null
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
    },
    getContactType()
    {
      API.getContactType().then(resp => {
        this.contactType = resp.data;
      });
    },
    addContact()
    {
      this.assignType(this.form.name);

      this.form.user_id = this.user.user_id;
      API.addContact(this.form).then( resp => {

        let id = resp.data;
        this.form.contact_id = id;
        this.closeDialog();
        this.contacts.push(this.form);
        this.form = {};
      });
    },
    deleteContact(contact)
    {
      API.deleteContact(contact).then(resp => {
        this.contacts = this.contacts.filter(c => c.contact_id != contact.contact_id);
      });
    },
    editContact()
    {
      this.assignType(this.form.name);

      API.editContact(this.form).then(resp => {
        this.closeDialog();
      });
    },
    dialogAddContact()
    {
      this.form = {};
      this.dialog = { open: true, mode: 'add' };
    },
    dialogEditContact(contact)
    {
      this.dialog = { open: true, mode: 'edit'};
      this.form = contact;

      //save before edit
      this.beforeEdit = Object.assign({}, contact);
    },
    closeDialog()
    {
      this.dialog = { open: false, mode: null };
    },
    cancelDialog()
    {
      this.dialog = { open: false, mode: null };
      Object.assign(this.form, this.beforeEdit);
    },
    assignType(type)
    {
      let currentType = this.contactType.find(contact => contact.name == type);
      this.form.icon = currentType.icon;
      this.form.contact_type_id = currentType.contact_type_id;
    }

  },
  created()
  {
    this.getContacts();
    this.getContactType();
  }
}
</script>

<style scoped>

.md-menu-item{
  cursor: pointer;
}




</style>
