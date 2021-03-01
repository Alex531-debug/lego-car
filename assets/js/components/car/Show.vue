<template>
  <div>
    <h1>Show {{ item && item['@id'] }}</h1>

    <div
      v-if="isLoading"
      class="alert alert-info"
      role="status">Loading...</div>
    <div
      v-if="error"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true">{{ error }}</span>
    </div>
    <div
      v-if="deleteError"
      class="alert alert-danger"
      role="alert">
      <span
        class="fa fa-exclamation-triangle"
        aria-hidden="true">{{ deleteError }}</span>
    </div>
    <div
      v-if="item"
      class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">название</th>
            <td>{{ item['name'] }}</td>
          </tr>
          <tr>
            <th scope="row">моедль</th>
            <td>{{ item['model'] }}</td>
          </tr>
          <tr>
            <th scope="row">vin</th>
            <td>{{ item['vin'] }}</td>
          </tr>
          <tr>
            <th scope="row">цена</th>
            <td>{{ item['price'] }}</td>
          </tr>
          <tr>
            <th scope="row">статус</th>
            <td>{{ prepareStatus(item['status']) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      :to="{ name: 'CarList' }"
      class="btn btn-primary">
      Back to list
    </router-link>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';

export default {
  computed: {
    ...mapFields('car/del', {
      deleteError: 'error',
    }),
    ...mapFields('car/show', {
      error: 'error',
      isLoading: 'isLoading',
      item: 'retrieved',
    }),
  },

  beforeDestroy () {
    this.reset();
  },

  created () {
    this.retrieve(decodeURIComponent(this.$route.params.id));
  },

  methods: {
    ...mapActions({
      del: 'car/del/del',
      reset: 'car/show/reset',
      retrieve: 'car/show/retrieve',
    }),

    deleteItem (item) {
      if (window.confirm('Are you sure you want to delete this item?')) {
        this.del(item).then(() => this.$router.push({ name: 'CarList' }));
      }
    },
    prepareStatus(status){
      switch (status) {
        case 'available':
          return 'В наличии'
          break;
        case 'on_order':
          return 'Подзаказ';
          break;
      }
      return null;
    }
  },
};
</script>
