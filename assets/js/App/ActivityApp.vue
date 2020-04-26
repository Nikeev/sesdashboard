<template>
  <div>
    <button type="button" @click="loadData" class="btn btn-secondary btn-sm float-right mb-3">Reload Data</button>

    <b-table striped hover
             :fields="fields"
             :items="rows"
             :busy="isBusy"
             @row-clicked="rowClicked">
      <template v-slot:table-busy>
        <div class="text-center text-primary my-2">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>

      <template v-slot:cell(subject)="data">
        <p><b>{{ data.item.subject }}</b></p>
        <p><b>To:</b> {{ data.item.destination.join(', ') }}</p>
      </template>

      <template v-slot:cell(timestamp)="data">
        {{ data.item.timestamp | formatDate }}
      </template>

    </b-table>
    <b-pagination
        v-if="totalRows > perPage"
        size="md"
        :total-rows="totalRows"
        v-model="currentPage"
        :per-page="perPage"></b-pagination>

<!--    <b-modal v-model="showDetails">-->
<!--      <b-spinner v-if="detailsLoading" class="align-middle"></b-spinner>-->
<!--      <div v-if="emailDetails">-->
<!--        <pre>-->
<!--          {{ emailDetails }}-->
<!--        </pre>-->
<!--      </div>-->
<!--    </b-modal>-->

    <app-email-details :show-details="showDetails" :mail-id="selectedId" @modal-closed="showDetails = false"></app-email-details>

  </div>
</template>

<script>
  import axios from 'axios';
  import moment from 'moment';
  import EmailDetails from "./Components/Activity/EmailDetails";

  export default {
    name: "ActivityApp",
    components: {
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
            limit: this.perPage
          }
        })
            .then(function (response) {
              console.log(response);
              _this.rows = response.data.rows;
              _this.totalRows = response.data.totalRows;
              _this.isBusy = false;
            })
            .catch(function (error) {
              console.log(error);
              _this.isBusy = false;
            })
            .then(function () {
              _this.isBusy = false;
            });
      },
      rowClicked(record, index) {
        console.log(record);
        this.showDetails = true;
        this.selectedId = record.id;
        // this.loadDetails(record.id);
      }
    },
    filters: {
      formatDate: function (value) {
        if (!value) return '';
        return moment(value).format();
      }
    },
    mounted() {
      this.loadData();
    }
  }
</script>

<style scoped>

</style>