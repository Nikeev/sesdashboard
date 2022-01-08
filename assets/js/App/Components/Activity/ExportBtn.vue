<template>
  <b-dropdown variant="outline-secondary" right>
    <template #button-content>
      <i class="fas fa-download"></i>
    </template>
    <b-dropdown-item :href="exportExcelUrl"><i class="fas fa-file-excel"></i> Excel</b-dropdown-item>
    <b-dropdown-item :href="exportCsvUrl"><i class="fas fa-file-csv"></i> CSV</b-dropdown-item>
  </b-dropdown>
</template>

<script>
import {BDropdown, BDropdownItem} from "bootstrap-vue";
import moment from "moment";

export default {
  name: 'app-export-btn',
  props: ['startDate', 'endDate', 'search', 'eventSelected'],
  components: {
    BDropdown,
    BDropdownItem
  },
  data() {
    return {
      exportBaseUrl: window.APP_EXPORT_URL
    }
  },
  computed: {
    exportUrl() {
      const params = {
        dateFrom: moment(this.startDate).startOf('day').utc().toISOString(),
        dateTo: moment(this.endDate).endOf('day').utc().toISOString()
      };

      if (this.search.length) {
        params['search'] = this.search;
      }

      if (this.eventSelected) {
        params['eventType'] = this.eventSelected;
      }

      return this.exportBaseUrl + '?' + new URLSearchParams(params).toString();
    },
    exportExcelUrl() {
      return this.exportUrl + '&format=excel';
    },
    exportCsvUrl() {
      return this.exportUrl + '&format=csv';
    }
  },
}
</script>
