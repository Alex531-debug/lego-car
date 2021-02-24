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
            <th scope="row">name</th>
            <td>{{ item['name'] }}</td>
          </tr>
          <tr>
            <th scope="row">createdAt</th>
            <td>{{ item['createdAt'] }}</td>
          </tr>
          <tr>
            <th scope="row">updatedAt</th>
            <td>{{ item['updatedAt'] }}</td>
          </tr>
          <tr>
            <th scope="row">cars</th>
            <td>{{ item['cars'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      :to="{ name: 'BrandList' }"
      class="btn btn-primary">
      Back to list
    </router-link>
    <router-link
      v-if="item"
      :to="{ name: 'BrandUpdate', params: { id: item['@id'] } }"
      class="btn btn-warning">
      Edit
    </router-link>
    <button
      class="btn btn-danger"
      @click="deleteItem(item)">Delete</button>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';

export default {
  computed: {
    ...mapFields('brand/del', {
      deleteError: 'error',
    }),
    ...mapFields('brand/show', {
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
      del: 'brand/del/del',
      reset: 'brand/show/reset',
      retrieve: 'brand/show/retrieve',
    }),

    deleteItem (item) {
      if (window.confirm('Are you sure you want to delete this item?')) {
        this.del(item).then(() => this.$router.push({ name: 'BrandList' }));
      }
    },
  },
};
</script>
