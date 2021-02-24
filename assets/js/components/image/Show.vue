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
            <th scope="row">image</th>
            <td>{{ item['image'] }}</td>
          </tr>
          <tr>
            <th scope="row">imageFile</th>
            <td>{{ item['imageFile'] }}</td>
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
            <th scope="row">car</th>
            <td>{{ item['car'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <router-link
      :to="{ name: 'ImageList' }"
      class="btn btn-primary">
      Back to list
    </router-link>
    <router-link
      v-if="item"
      :to="{ name: 'ImageUpdate', params: { id: item['@id'] } }"
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
    ...mapFields('image/del', {
      deleteError: 'error',
    }),
    ...mapFields('image/show', {
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
      del: 'image/del/del',
      reset: 'image/show/reset',
      retrieve: 'image/show/retrieve',
    }),

    deleteItem (item) {
      if (window.confirm('Are you sure you want to delete this item?')) {
        this.del(item).then(() => this.$router.push({ name: 'ImageList' }));
      }
    },
  },
};
</script>
