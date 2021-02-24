<template>
  <form @submit.prevent="handleSubmit(item)">
    <div class="form-group">
      <label
        for="image_image"
        class="form-control-label">image</label>
        <input
          id="image_image"
          v-model="item.image"
          :class="['form-control', !isValid('image') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('image')"
        class="invalid-feedback">{{ violations.image }}</div>
    </div>
    <div class="form-group">
      <label
        for="image_imageFile"
        class="form-control-label">imageFile</label>
        <input
          id="image_imageFile"
          v-model="item.imageFile"
          :class="['form-control', !isValid('imageFile') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('imageFile')"
        class="invalid-feedback">{{ violations.imageFile }}</div>
    </div>
    <div class="form-group">
      <label
        for="image_car"
        class="form-control-label">car</label>
        <select
          v-model="item.car"
          id="image_car"
          class="form-control"
        >
          <option v-for="selectItem in carSelectItems"
                  :key="selectItem['@id']"
                  :value="selectItem['@id']"
                  :selected="isSelected('car', selectItem['@id'])">{{ selectItem.name }}
          </option>
        </select>
      <div
        v-if="!isValid('car')"
        class="invalid-feedback">{{ violations.car }}</div>
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
    this.carGetSelectItems();
  },

  computed: {
    ...mapFields('car/list', {
      'carSelectItems': 'selectItems',
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
        carGetSelectItems: 'car/list/getSelectItems',
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
