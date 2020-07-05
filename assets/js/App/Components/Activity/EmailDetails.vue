<template>
  <b-modal
      v-model="showModal"
      title="Email Details"
      size="lg">
    <div v-if="detailsLoading" class="text-center">
      <b-spinner variant="primary"></b-spinner>
    </div>

    <div v-if="emailDetails">

      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr>
              <th>Subject</th>
              <td>{{ emailDetails.subject }}</td>
            </tr>
            <tr>
              <th>MessageId</th>
              <td>{{ emailDetails.messageId }}</td>
            </tr>
            <tr>
              <th>Destination</th>
              <td>{{ emailDetails.destination.join(', ') }}</td>
            </tr>
            <tr>
              <th>Source</th>
              <td>{{ emailDetails.source }}</td>
            </tr>
            <tr>
              <th>DateTime</th>
              <td>{{ emailDetails.timestamp }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <h5>Events Log</h5>
      <ul class="list-group">
        <li class="list-group-item"
            v-for="emailEvent in emailDetails.emailEvents"
            :key="emailEvent.id"
        >
          <div>
            <b-button
                v-b-toggle="'collapse-' + emailEvent.id"
                size="sm"
                variant="light"
                class="float-right">Show details</b-button>
            <i class="far fa-dot-circle text-primary"></i>
            <span class="text-capitalize lead">{{ emailEvent.event }}</span>
            <small>{{ emailEvent.timestamp }}</small>
          </div>

          <b-collapse :id="'collapse-' + emailEvent.id" class="bg-light p-4">
            <pre><code>{{ emailEvent.eventData }}</code></pre>
          </b-collapse>
        </li>
      </ul>

<!--        <pre>-->
<!--          {{ emailDetails }}-->
<!--        </pre>-->
    </div>

    <template v-slot:modal-footer>
      <div class="w-100">
        <b-button
            variant="primary"
            size="sm"
            class="float-right"
            @click="showModal=false"
        >
          Close
        </b-button>
      </div>
    </template>
  </b-modal>
</template>

<script>
  import axios from "axios";
  import { BCollapse, BButton, VBToggle } from 'bootstrap-vue'

  export default {
    name: "EmailDetails",
    props: ['mailId', 'showDetails'],
    components: {
      BCollapse,
      BButton
    },
    directives: {
      'b-toggle': VBToggle
    },
    data() {
      return {
        showModal: this.showDetails,
        detailsLoading: true,
        emailDetails: null
      }
    },
    methods: {
      loadDetails() {
        this.detailsLoading = true;
        this.emailDetails = null;

        let _this = this;

        axios.get('/activity/details/api', {
          params: {
            id: _this.mailId
          }
        })
            .then(function (response) {
              console.log(response);
              _this.emailDetails = response.data;
            })
            .catch(function (error) {
              console.log(error);
              _this.detailsLoading = false;
            })
            .then(function () {
              _this.detailsLoading = false;
            });
      }
    },
    watch: {
      showDetails() {
        this.showModal = this.showDetails;
      },
      showModal() {
        if (this.showModal) {
          this.loadDetails();
        }
        else {
          this.$emit('modal-closed', true);
        }
      }
    }
  }
</script>

<style scoped>

</style>