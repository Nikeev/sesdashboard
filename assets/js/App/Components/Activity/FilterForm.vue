<template>
  <b-row class="mb-3">
    <b-col>
      <b-form-input v-model="search" @input="$emit('search', $event)" placeholder="Search Email or Subject"></b-form-input>
    </b-col>
    <b-col>
      <app-date-range-picker v-model="dateRange" />
    </b-col>
    <b-col>
      <b-form-select v-model="eventSelected" :options="eventOptions"></b-form-select>
    </b-col>
    <b-col>
      <b-button variant="outline-primary" @click="$emit('reload')"><i class="fas fa-search"></i> Search</b-button>
      <b-button v-b-tooltip.hover title="Clear filters" variant="outline-secondary" @click="clear"><i class="fas fa-times"></i></b-button>
    </b-col>
  </b-row>
</template>

<script>
import { BFormInput, BRow, BCol, BButton, BFormSelect  } from 'bootstrap-vue'
import AppDateRangePicker from "../Common/AppDateRangePicker";
import moment from "moment";

export default {
  name: "FilterForm",
  components: {
    AppDateRangePicker,
    BRow,
    BCol,
    BButton,
    BFormInput,
    BFormSelect
  },
  data() {
    return {
      search: '',
      dateRange: {
        startDate: moment().locale(window.navigator.language).startOf('week').utc().toDate(),
        endDate: moment().locale(window.navigator.language).endOf('week').utc().toDate()
      },
      eventSelected: null,
      eventOptions: [
        { value: null, text: 'Select an event' },
        { value: 'send', text: 'Send' },
        { value: 'delivery', text: 'Delivery'},
        { value: 'reject', text: 'Reject'},
        { value: 'bounce', text: 'Bounce'},
        { value: 'complaint', text: 'Complaint'},
        { value: 'failure', text: 'Failure'},
        { value: 'open', text: 'Open'},
        { value: 'click', text: 'Click'},
      ]
    }
  },
  methods: {
    clear() {
      this.search = '';
      this.$emit('search', '');
      this.$emit('date-from', '');
      this.$emit('date-to', '');
      this.$emit('reload');
    }
  },
  watch: {
    dateRange() {
      this.$emit('date-from', this.dateRange.startDate);
      this.$emit('date-to', this.dateRange.endDate);
    },
    eventSelected() {
      this.$emit('event-selected', this.eventSelected);
    }
  },
  mounted() {
    this.$emit('date-from', this.dateRange.startDate);
    this.$emit('date-to', this.dateRange.endDate);
  }
}
</script>

<style scoped>

</style>