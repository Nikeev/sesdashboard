<template>
  <div v-if="projectId">

    <div class="mb-4 w-25">
      <app-date-range-picker v-model="dateRange" />
    </div>

    <counters-cards :counters="counters" :is-loading="isLoading" />

    <div class="small mb-5">
      <line-chart :chart-data="datacollection" :options="chartOptions"></line-chart>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import LineChart from './Components/Dashboard/LineChart';
import CountersCards from "./CountersCards";
import AppDateRangePicker from "./Components/Common/AppDateRangePicker";

export default {
  name: "DashboardApp",
  components: {
    AppDateRangePicker,
    CountersCards,
    LineChart
  },
  data() {
    return {
      isLoading: true,
      projectId: window.dashboardProjectId,
      dateRange: {
        startDate: moment().locale(window.navigator.language).startOf('week').utc().toDate(),
        endDate: moment().locale(window.navigator.language).endOf('week').utc().toDate()
      },
      datacollection: {},
      counters: {},
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        }
      },
      chartColors: {
        Send: '#6c757d',
        Delivery: '#28a745',
        Reject: '#db5b67',
        Bounce: '#c8c8c8',
        Complaint: '#dc3545',
        Failure: '#e59aa2',
        Open: '#007bff',
        Click: '#ffc107'
      }
    }
  },
  filters: {
    date(value) {
      return moment(value).format('MMMM Do YYYY');
    }
  },
  methods: {
    loadData() {
      let _this = this;

      axios.get(window.dashboardEndpoint, {
        params: {
          projectId: parseInt(this.projectId),
          dateFrom:  moment(this.dateRange.startDate).startOf('day').utc().toDate(),
          dateTo: moment(this.dateRange.endDate).endOf('day').utc().toDate(),
          tzOffset: moment().utcOffset()
        }
      })
          .then(response => {
            _this.isLoading = false;

            _this.counters = response.data.counters;
            _this.fillChartData(response.data.chartData);
          })
          .catch(error => {
            if (error.response) {
              alert(error.response.data.error);
            }
            else {
              alert(error);
            }
          })
          .then(() => {

          });
    },
    fillChartData(data) {
      let datasets = [];
      data.datasets.forEach(element => {
        let dataset = {
          label: element.label,
          data: element.data,
          backgroundColor: this.chartColors[element.label],
          borderColor: this.chartColors[element.label],
          fill: false
        };
        datasets.push(dataset);
      });

      let labels = [];
      data.labels.forEach(element => {
        labels.push(moment(element).format('L'));
      });

      this.datacollection = {
        labels: labels,
        datasets: datasets
      };
    }
  },
  computed: {
    firstDayOfWeek() {
      return moment.localeData(window.navigator.language).firstDayOfWeek();
    }
  },
  watch: {
    dateRange() {
      this.loadData();
    }
  },
  mounted() {
    if (this.projectId) {
      this.loadData();
    }
  }
}
</script>
