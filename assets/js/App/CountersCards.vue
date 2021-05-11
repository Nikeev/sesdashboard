<template>
  <div class="card-deck mb-5">

    <div class="card bg-light text-center">
      <div class="card-body">
        <h6 class="text-uppercase">Sent</h6>
        <i v-if="isLoading" class="fa fa-spinner fa-spin fa-3x text-muted"></i>
        <div v-else>
          <h3 class="text-muted">{{ counters.sent | number }}</h3>
        </div>
      </div>
    </div>

    <div class="card bg-light text-center">
      <div class="card-body">
        <h6 class="text-uppercase">Delivered</h6>
        <i v-if="isLoading" class="fa fa-spinner fa-spin fa-3x text-muted"></i>
        <div v-else>
          <h4 class="text-success mb-0">{{ counters.delivered | number }}</h4>
          <div class="text-muted">{{ deliveredProc | number }}%</div>
        </div>
      </div>
    </div>

    <div class="card bg-light text-center">
      <div class="card-body">
        <h6 class="text-uppercase">Opens</h6>
        <i v-if="isLoading" class="fa fa-spinner fa-spin fa-3x text-muted"></i>
        <h4 v-else class="text-primary">{{ counters.opens | number }}</h4>
      </div>
    </div>

    <div class="card bg-light text-center">
      <div class="card-body">
        <h6 class="text-uppercase">Clicks</h6>
        <i v-if="isLoading" class="fa fa-spinner fa-spin fa-3x text-muted"></i>
        <h4 v-else class="text-warning">{{ counters.clicks | number }}</h4>
      </div>
    </div>

    <div class="card bg-light text-center">
      <div class="card-body">
        <h6 class="text-uppercase">Not Delivered</h6>
        <i v-if="isLoading" class="fa fa-spinner fa-spin fa-3x text-muted"></i>
        <div v-else>
          <h4 class="text-danger mb-0">{{ counters.notDelivered | number }}</h4>
          <div class="text-muted">{{ notDeliveredProc | number }}%</div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
export default {
  name: 'counters-cards',
  props: {
    isLoading: Boolean,
    counters: Object
  },
  computed: {
    deliveredProc() {
      return this.counters.sent ? (this.counters.delivered / this.counters.sent * 100) : 0;
    },
    notDeliveredProc() {
      return this.counters.sent ? (this.counters.notDelivered / this.counters.sent * 100) : 0;
    }
  },
  filters: {
    number(value) {
      if (!value) return 0;
      return new Intl.NumberFormat([], {maximumFractionDigits: 2}).format(value);
    }
  }
}
</script>
