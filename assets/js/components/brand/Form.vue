<template>
  <form @submit.prevent="handleSubmit(item)">
    <div class="form-group">
      <label
        for="brand_name"
        class="form-control-label">name</label>
        <input
          id="brand_name"
          v-model="item.name"
          :class="['form-control', !isValid('name') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('name')"
        class="invalid-feedback">{{ violations.name }}</div>
    </div>
    <div class="form-group">
      <label
        for="brand_cars"
        class="form-control-label">cars</label>
        <select
          v-model="item.cars"
          id="brand_cars"
          multiple
          class="form-control"
        >
          <option v-for="selectItem in carsSelectItems"
                  :key="selectItem['@id']"
                  :value="selectItem['@id']"
                  :selected="isSelected('cars', selectItem['@id'])">{{ selectItem.name }}
          </option>
        </select>
      <div
        v-if="!isValid('cars')"
        class="invalid-feedback">{{ violations.cars }}</div>
    </div>

    <button
      type="submit"
      class="btn btn-success">Submit</button>
  </form>
</template>

<script>
  import { find, get, isUndefined } from 'lodash';
  import { mapFields } from 'vuex-map-fields';
  import { mapActions } from 'vuex';

  export default {
  props: {
    handleSubmit: {
      type: Function,
      required: true,
    },

    values: {
      type: Object,
      required: true,
    },

    errors: {
      type: Object,
      default: () => {},
    },

    initialValues: {
      type: Object,
      default: () => {},
    }
  },

  mounted() {
    this.carsGetSelectItems();
  },

  computed: {
    ...mapFields('cars/list', {
      'carsSelectItems': 'selectItems',
    }),

    // eslint-disable-next-line
    item() {
      return this.initialValues || this.values;
    },

    violations() {
      return this.errors || {};
    },
  },

  methods: {
    ...mapActions({
        carsGetSelectItems: 'cars/list/getSelectItems',
    }),

    isSelected(collection, id) {
      return find(this.item[collection], ['@id', id]) !== undefined;
    },

    isValid(key) {
      return isUndefined(get(this.violations, key));
    },
  },
};
</script>
