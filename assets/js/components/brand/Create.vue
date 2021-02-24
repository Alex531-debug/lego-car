<template>
  <div>
    <h1>New Brand</h1>

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

    <BrandForm
      :handle-submit="onSendForm"
      :values="item"
      :errors="violations" />

    <router-link
      :to="{ name: 'BrandList' }"
      class="btn btn-default">Back to list</router-link>
  </div>
</template>

<script>
import { createHelpers } from 'vuex-map-fields';
import { mapActions } from 'vuex';
import BrandForm from './Form';

const { mapFields } = createHelpers({
    getterType: 'brand/create/getField',
    mutationType: 'brand/create/updateField',
});

export default {
  components: {
    BrandForm,
  },

  data () {
    return {
      item: {},
    };
  },

  computed: {
    ...mapFields([
      'error',
      'isLoading',
      'created',
      'violations',
    ]),
  },

  watch: {
    // eslint-disable-next-line object-shorthand,func-names
    created: function(created) {
      if (!created) {
        return;
      }

      this.$router.push({ name: 'BrandUpdate', params: { id: created['@id'] } });
    }
  },

  methods: {
    ...mapActions('brand/create', [
      'create',
    ]),

    onSendForm () {
      this.create(this.item);
    },
  },
};
</script>
