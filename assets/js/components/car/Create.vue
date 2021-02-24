<template>
  <div>
    <h1>New Car</h1>

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

    <CarForm
      :handle-submit="onSendForm"
      :values="item"
      :errors="violations" />

    <router-link
      :to="{ name: 'CarList' }"
      class="btn btn-default">Back to list</router-link>
  </div>
</template>

<script>
import { createHelpers } from 'vuex-map-fields';
import { mapActions } from 'vuex';
import CarForm from './Form.vue';

const { mapFields } = createHelpers({
    getterType: 'car/create/getField',
    mutationType: 'car/create/updateField',
});

export default {
  components: {
    CarForm,
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

      this.$router.push({ name: 'CarUpdate', params: { id: created['@id'] } });
    }
  },

  methods: {
    ...mapActions('car/create', [
      'create',
    ]),

    onSendForm () {
      this.create(this.item);
    },
  },
};
</script>
