export default {
  methods: {

  },
  filters: {
    parseDate(unix)
    {
        const dt = new Date(unix*1000);
        let hours = dt.getHours();
        let minutes = dt.getMinutes();
        if(hours<9)
        {
          hours = `0${hours}`;
        }

        if(minutes<9)
        {
          minutes = `0${minutes}`;
        }

        return `${dt.getDate()}.${dt.getMonth()+1}.${dt.getFullYear()} ${hours}:${minutes}`;
    }
  }
}
