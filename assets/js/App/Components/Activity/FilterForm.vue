<template>
  <b-row>
    <b-col>
      <b-form-input v-model="search" @input="$emit('search', $event)" placeholder="Search Email or Subject"></b-form-input>
    </b-col>
    <b-col>
      <b-form-datepicker
          v-model="dateFrom"
          @input="$emit('date-from', $event)"
          placeholder="Date from"
          :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
          class="mb-2"></b-form-datepicker>
    </b-col>
    <b-col>
      <b-form-datepicker
          v-model="dateTo"
          @input="$emit('date-to', $event)"
          placeholder="Date to"
          :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
          class="mb-2"></b-form-datepicker>
    </b-col>
    <b-col>
      <b-button variant="outline-primary" @click="$emit('reload')"><i class="fas fa-search"></i> Search</b-button>
      <b-button v-b-tooltip.hover title="Clear filters" variant="outline-secondary" @click="clear"><i class="fas fa-times"></i></b-button>
    </b-col>
  </b-row>
</template>

<script>
import { BFormInput, BRow, BCol, BButton, BFormDatepicker } from 'bootstrap-vue'

export default {
  name: "FilterForm",
  components: {
    BRow,
    BCol,
    BButton,
    BFormInput,
    BFormDatepicker
  },
  data() {
    return {
      search: '',
      dateFrom: '',
      dateTo: ''
    }
  },
  methods: {
    clear() {
      this.search = '';
      this.dateFrom = '';
      this.dateTo = '';
      this.$emit('search', '');
      this.$emit('date-from', '');
      this.$emit('date-to', '');
      this.$emit('reload');
    }
  }
}
</script>

<style scoped>

</style>