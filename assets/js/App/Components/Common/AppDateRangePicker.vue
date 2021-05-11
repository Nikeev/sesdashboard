<template>
  <date-range-picker
      ref="picker"
      :opens="'right'"
      v-model="dateRange"
      :autoApply="true"
      @update="update"
      :ranges="ranges"
      :locale-data="{ firstDay: firstDayOfWeek }"
  >
    <template v-slot:input="picker" style="min-width: 350px;">
      <i class="fa fa-calendar-alt"></i> {{ picker.startDate | date }} - {{ picker.endDate | date }}
    </template>
  </date-range-picker>
</template>

<script>

import moment from 'moment';
import DateRangePicker from 'vue2-daterange-picker';
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';

export default {
  name: "AppDateRangePicker",
  components: {
    DateRangePicker
  },
  props: ['value'],
  data() {
    return {
      dateRange: this.value,
      ranges: {
        'Today': [
          moment().locale(window.navigator.language).startOf('day').toDate(),
          moment().locale(window.navigator.language).endOf('day').toDate()
        ],
        'Yesterday': [
          moment().locale(window.navigator.language).startOf('day').subtract(1, 'days').toDate(),
          moment().locale(window.navigator.language).endOf('day').subtract(1, 'days').toDate()
        ],
        'This week': [
          moment().locale(window.navigator.language).startOf('week').toDate(),
          moment().locale(window.navigator.language).endOf('week').toDate()
        ],
        'Last week': [
          moment().locale(window.navigator.language).subtract(1, 'weeks').startOf('week').toDate(),
          moment().locale(window.navigator.language).subtract(1, 'weeks').endOf('week').toDate()
        ],
        'This month': [
          moment().locale(window.navigator.language).startOf('month').toDate(),
          moment().locale(window.navigator.language).endOf('month').toDate()
        ],
        'Last month': [
          moment().locale(window.navigator.language).subtract(1, 'months').startOf('month').toDate(),
          moment().locale(window.navigator.language).subtract(1, 'months').endOf('month').toDate()
        ],
      }
    }
  },
  filters: {
    date(value) {
      return moment(value).locale(window.navigator.language).format('YYYY-MM-DD');
    }
  },
  computed: {
    firstDayOfWeek() {
      return moment.localeData(window.navigator.language).firstDayOfWeek();
    }
  },
  methods: {
    update() {
      this.$emit('input', {
        startDate: this.dateRange.startDate,
        endDate: this.dateRange.endDate
      });
    }
  }
}
</script>

<style>
@media screen and (min-width:768px) {
  .daterangepicker.show-ranges {
    min-width: 715px!important;
  }
  .vue-daterange-picker {
    width: 100%;
  }
}
</style>