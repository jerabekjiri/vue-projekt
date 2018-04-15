<template>
  <div>
  <md-card>
    <div class="md-layout">
      <div class="md-layout-item">

    <md-card-header>

    <div class="md-title">SIGN IN</div>
    </md-card-header>
    <md-card-content>
    <md-field>
      <label>Email</label>
      <md-input v-model="form.email"></md-input>
    </md-field>

    <md-field>
      <label>Password</label>
      <md-input v-model="form.password" type="password"></md-input>
    </md-field>

    <md-card-actions>
      <md-button type="submit" class="md-primary" @click="signIn()">Sign In</md-button>
  </md-card-actions>



  </md-card-content>
  </div>
  <div class="horizontal-line">

  </div>
  <div class="md-layout-item">
      <md-card-header>
    <div class="md-title">DON'T HAVE AN ACCOUNT?</div>

    </md-card-header>
    <md-card-content>
      <p class="md-body-2">
       Your account allows you to join and share meetups.
      </p>
      <md-button class="md-raised md-primary centered" to="/signup">SIGN UP</md-button>

    </md-card-content>

  </div>
</div>
</md-card>

<md-snackbar md-position="center":md-active="isError" md-persistent>
  <span>Bad Email or Password, please repeat!</span>
  <md-button class="md-primary" @click="closeSnackbar()">Close</md-button>
</md-snackbar>
  </div>
</template>

<script>
import API from '../api/auth';

  export default {
    computed: {
      isError()
      {
        return this.$store.state.AuthModule.error;
      }
  },
    data() {
      return {
          form: {
            email: null,
            password: null
          },
          showSnackbar: false
      }
    },
    methods: {
      signIn()
      {
        this.$store.dispatch('AUTH_REQUEST', this.form).then(resp => {
          this.$router.push('/profile');

        })
      },
      closeSnackbar()
      {
        this.$store.commit('ERROR', false);
      }
    },
    created()
    {

    }
  }
</script>

<style scoped>
  .horizontal-line{
    border-left: 1px solid #e6e6e6;
    height: 240px;
    margin-top: 30px;
  }

  .centered{
  margin: 0px auto;
  display: block;
  }
</style>
