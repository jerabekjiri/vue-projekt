<template>
  <div>
    <md-dialog :md-active.sync="dialog" class="dialog" :md-click-outside-to-close="false">
         <md-dialog-title>Create a Meetup</md-dialog-title>
         <md-dialog-content>
           <md-field>
             <label>Title</label>
             <md-input v-model="form.title"></md-input>
          </md-field>

          <md-field>
            <label>Information</label>
            <md-textarea v-model="form.info" md-autogrow></md-textarea>
         </md-field>

         <md-field>
           <label>Location</label>
           <md-input v-model="form.location"></md-input>
        </md-field>
        <div class="md-layout">
          <div class="md-layout-item">
              <md-datepicker v-model="date" :md-disabled-dates="disabledDates">
              <label></label>
              </md-datepicker>
          </div>

        <div class="md-layout-item">
            <md-field>
              <label>Time</label>
            <md-input v-model="time" type="time" />
          </md-field>
      </div>
    </div>
    </md-dialog-content>

         <md-dialog-actions>
           <md-button class="md-primary" @click="$emit('close')">Close</md-button>
           <md-button class="md-primary" @click="createMeetup()">Create</md-button>
         </md-dialog-actions>
      </md-dialog>
  </div>
</template>

<script>
export default {
  props: ['dialog'],
  data()
  {
    return {
      form: {},
      date: null,
      time: null,
      disabledDates: date => {
        const year = date.getFullYear()
        const month = date.getMonth()+1;
        const day = date.getDate();

        const now = new Date();
        const todayYear = now.getFullYear();
        const todayMonth = now.getMonth()+1;
        const todayDay = now.getDate();
/*
        if(todayYear > year)
        {
          return year;
        }*///// TODO: forbid to set meetup to past time!
        if(todayMonth == month)
        {
          if(todayYear == year)
          {
            return year < todayYear || month < todayMonth || day < todayDay+1;
          }
        }

      }
    }
  },
  methods: {
    createMeetup()
    {
      this.createURL();

      this.parseDateToUnixStamp();

      this.$store.dispatch('CREATE_MEETUP', this.form).then( resp => {

        this.$emit('close');
        this.$router.push('/meetup/' + this.form.url + '/edited');

      });
    },
    createURL()
    {
      this.form.url = this.form.title.toLowerCase().split(' ').join('-').normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    },
    parseDateToUnixStamp()
    {

    let date = this.date.toString();

    date = date.replace('00:00:00', this.time);

    this.form.date = Date.parse(date)/1000;

    }
  }
}
</script>

<style lang="css">
</style>
