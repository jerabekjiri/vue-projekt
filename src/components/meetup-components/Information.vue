<template>
  <div v-html="information" class="text-block">

  </div>
</template>

<script>
export default {
  computed: {
    information()
    {
      return this.$store.state.MeetupsModule.meetup.information;
    }
  }
}
</script>

<style scoped>

.text-block
{
    text-align: justify;
}


</style>
