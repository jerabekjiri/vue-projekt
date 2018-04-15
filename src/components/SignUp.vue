<template>
  <div>
  <md-card>
    <md-card-header>
    <div class="md-title">Sign up</div>
    </md-card-header>
    <md-card-content>
    <md-field>
      <label>Name</label>
      <md-input v-model="form.name"></md-input>
    </md-field>

    <md-field>
      <label>Email</label>
      <md-input v-model="form.email" @keyup="checkIfEmailExist"></md-input>
    </md-field>

    <md-field>
      <label>Password</label>
      <md-input v-model="form.password" type="password"></md-input>
    </md-field>

    <md-field>
      <label>Repeat password</label>
      <md-input v-model="form.passwordConfirm" type="password"></md-input>
    </md-field>

    <md-card-actions>
      <md-button type="submit" class="md-primary" @click="signUp()" :disabled="isValid" >Sign Up</md-button>
  </md-card-actions>


  </md-card-content>
</md-card>


<md-snackbar :md-active.sync="showSnackbar" md-persistent  :md-position="'center'">
    <span>SUCCESFULLY SIGNED UP</span>
  <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
</md-snackbar>
  </div>
</template>

<script>
import API from '../api/auth';

  export default {
    data() {
      return {
          form: {
            name: null,
            email: null,
            password: null,
            passwordConfirm: null
          },
          showSnackbar: false,
          timeout: null
      }
    },
    computed: {
      isAllFilled()
      {
        if(this.form.name &&
           this.form.email &&
           this.form.password &&
           this.form.passwordConfirm)
          return true;

        return false;
      },
      passwordsEqual()
      {
        if(this.form.password == this.form.passwordConfirm)
          return true;

        return false;
      },
      isValid()
      {
      if(this.isAllFilled && this.passwordsEqual)
        return false

      return true;
      }
    },
    methods: {
      signUp()
      {
        this.createUserHref();

        this.$store.dispatch('AUTH_SIGNUP', this.form).then(() => {
          this.$router.push('/profile');
        });

        this.showSnackbar = true;
      },
      checkIfEmailExist()
      {
      /*  clearTimeout(this.timeout);
        this.timeout = setTimeout( () => {
          this.fetch();
        }, 1000);
*/
      },
      fetch()
      {
      //  API.emailUnique(this.form.email);
    },
      createUserHref(name)
      {
        this.form.href =  this.form.name.toLowerCase().split(' ').join('-').normalize('NFD').replace(/[\u0300-\u036f]/g, "");
      }
    }
  }
</script>
