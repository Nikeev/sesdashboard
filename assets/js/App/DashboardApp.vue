<template>
  <div v-if="projectId">

    <div class="mb-4">
      <date-range-picker
          ref="picker"
          :opens="'right'"
          v-model="dateRange"
          :autoApply="true"
          @update="loadData"
          :ranges="ranges"
      >
        <template v-slot:input="picker" style="min-width: 350px;">
          <i class="fa fa-calendar-alt"></i> {{ picker.startDate | date }} - {{ picker.endDate | date }}
        </template>
      </date-range-picker>
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
import DateRangePicker from 'vue2-daterange-picker';
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';
import CountersCards from "./CountersCards";

export default {
  name: "DashboardApp",
  components: {
    CountersCards,
    LineChart,
    DateRangePicker
  },
  data() {
    return {
      isLoading: true,
      projectId: window.dashboardProjectId,
      dateRange: {
        startDate: moment().startOf('week').toDate(),
        endDate: moment().endOf('week').toDate()
      },
      // TODO It seems that range start date doesn't update current start date.
      ranges: {
        'Today': [
          moment().startOf('day').toDate(),
          moment().endOf('day').toDate()
        ],
        'Yesterday': [
          moment().startOf('day').subtract(1, 'days').toDate(),
          moment().endOf('day').subtract(1, 'days').toDate()
        ],
        'This week': [
          moment().startOf('week').toDate(),
          moment().endOf('week').toDate()
        ],
        'Last week': [
          moment().subtract(1, 'weeks').startOf('week').toDate(),
          moment().subtract(1, 'weeks').endOf('week').toDate()
        ],
        'This month': [
          moment().startOf('month').toDate(),
          moment().endOf('month').toDate()
        ],
        'Last month': [
          moment().subtract(1, 'months').startOf('month').toDate(),
          moment().subtract(1, 'months').endOf('month').toDate()
        ],
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
          dateFrom: moment(this.dateRange.startDate).utc().startOf('day').toDate(),
          dateTo: moment(this.dateRange.endDate).utc().endOf('day').toDate()
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
  mounted() {
    if (this.projectId) {
      this.loadData();
    }
  }
}
</script>

