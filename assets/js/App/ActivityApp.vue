<template>
  <div>
    <app-filter-form
        @reload="loadData"
        @search="search = $event"
        @date-from="dateFrom = $event"
        @date-to="dateTo = $event"
        @event-selected="eventSelected = $event"
    />

    <b-table hover show-empty
             :fields="fields"
             :items="rows"
             :busy="isBusy"
             @row-clicked="rowClicked">
      <template #empty="scope">
        <div class="text-center lead">No emails to display</div>
      </template>

      <template v-slot:table-busy>
        <div class="text-center text-primary my-2">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>

      <template v-slot:cell(status)="data">
        <i class="fas fa-dot-circle" :class="'status-' + data.item.status"></i> <span class="text-capitalize">{{ data.item.status }}</span>
      </template>

      <template v-slot:cell(subject)="data">
        <p><b>{{ data.item.subject }}</b></p>
        <p><b>To:</b> {{ data.item.destination.join(', ') }}</p>
      </template>

      <template v-slot:cell(timestamp)="data">
        <span :title="data.item.timestamp"> {{ data.item.timestamp | formatDate }}</span>
      </template>

    </b-table>
    <b-pagination
        v-if="totalRows > perPage"
        size="md"
        :total-rows="totalRows"
        v-model="currentPage"
        :per-page="perPage"></b-pagination>

    <app-email-details :show-details="showDetails" :mail-id="selectedId" @modal-closed="showDetails = false"></app-email-details>

  </div>
</template>

<script>
  import axios from 'axios';
  import moment from 'moment';
  import EmailDetails from "./Components/Activity/EmailDetails";
  import FilterForm from "./Components/Activity/FilterForm";

  export default {
    name: "ActivityApp",
    components: {
      appFilterForm: FilterForm,
      appEmailDetails: EmailDetails
    },
    data() {
      return {
        isBusy: false,
        showDetails: false,
        detailsLoading: false,
        emailDetails: null,
        selectedId: null,
        rows: [],
        search: '',
        dateFrom: '',
        dateTo: '',
        eventSelected: null,
        fields: [
          {
            key: 'status',
            label: 'Status'
          },
          {
            key: 'subject',
            label: 'Message'
          },
          {
            key: 'timestamp',
            label: 'Sent at'
          },
          {
            key: 'opens',
            label: 'Opens'
          },
          {
            key: 'clicks',
            label: 'Clicks'
          }
        ],
        currentPage: 1,
        perPage: 10,
        totalRows: 0
      }
    },
    methods: {
      loadData() {
        let _this = this;

        _this.isBusy = true;
        axios.get('/activity/list/api', {
          params: {
            page: this.currentPage,
            limit: this.perPage,
            search: this.search,
            dateFrom: moment(this.dateFrom).startOf('day').utc().toDate(),
            dateTo: moment(this.dateTo).endOf('day').utc().toDate(),
            eventType: this.eventSelected
          }
        })
            .then(function (response) {
              _this.rows = response.data.rows;
              _this.totalRows = response.data.totalRows;
              _this.isBusy = false;
            })
            .catch(function (error) {
              _this.isBusy = false;
            })
            .then(function () {
              _this.isBusy = false;
            });
      },
      rowClicked(record, index) {
        this.showDetails = true;
        this.selectedId = record.id;
        // this.loadDetails(record.id);
      }
    },
    watch: {
      currentPage() {
        this.loadData();
      }
    },
    filters: {
      formatDate: function (value) {
        if (!value) return '';
        return moment(value).locale(window.navigator.language).local().format('LLL');
      }
    },
    mounted() {
      this.loadData();
    }
  }
</script>

<style>
  .b-table tbody tr {
    cursor: pointer;
  }
</style>