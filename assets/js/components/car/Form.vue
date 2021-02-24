<template>
  <form @submit.prevent="handleSubmit(item)">
    <div class="form-group">
      <label
        for="car_name"
        class="form-control-label">name</label>
        <input
          id="car_name"
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
        for="car_model"
        class="form-control-label">model</label>
        <input
          id="car_model"
          v-model="item.model"
          :class="['form-control', !isValid('model') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('model')"
        class="invalid-feedback">{{ violations.model }}</div>
    </div>
    <div class="form-group">
      <label
        for="car_vin"
        class="form-control-label">vin</label>
        <input
          id="car_vin"
          v-model="item.vin"
          :class="['form-control', !isValid('vin') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('vin')"
        class="invalid-feedback">{{ violations.vin }}</div>
    </div>
    <div class="form-group">
      <label
        for="car_price"
        class="form-control-label">price</label>
        <input
          id="car_price"
          v-model="item.price"
          :class="['form-control', !isValid('price') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('price')"
        class="invalid-feedback">{{ violations.price }}</div>
    </div>
    <div class="form-group">
      <label
        for="car_status"
        class="form-control-label">status</label>
        <input
          id="car_status"
          v-model="item.status"
          :class="['form-control', !isValid('status') ? 'is-invalid' : 'is-valid']"
          type="text"
          placeholder="">
      <div
        v-if="!isValid('status')"
        class="invalid-feedback">{{ violations.status }}</div>
    </div>
    <div class="form-group">
      <label
        for="car_images"
        class="form-control-label">images</label>
        <select
          v-model="item.images"
          id="car_images"
          multiple
          class="form-control"
        >
          <option v-for="selectItem in imagesSelectItems"
                  :key="selectItem['@id']"
                  :value="selectItem['@id']"
                  :selected="isSelected('images', selectItem['@id'])">{{ selectItem.name }}
          </option>
        </select>
      <div
        v-if="!isValid('images')"
        class="invalid-feedback">{{ violations.images }}</div>
    </div>
    <div class="form-group">
      <label
        for="car_brand"
        class="form-control-label">brand</label>
        <select
          v-model="item.brand"
          id="car_brand"
          class="form-control"
        >
          <option v-for="selectItem in brandSelectItems"
                  :key="selectItem['@id']"
                  :value="selectItem['@id']"
                  :selected="isSelected('brand', selectItem['@id'])">{{ selectItem.name }}
          </option>
        </select>
      <div
        v-if="!isValid('brand')"
        class="invalid-feedback">{{ violations.brand }}</div>
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
    this.imagesGetSelectItems();
    this.brandGetSelectItems();
  },

  computed: {
    ...mapFields('images/list', {
      'imagesSelectItems': 'selectItems',
    }),
    ...mapFields('brand/list', {
      'brandSelectItems': 'selectItems',
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
        imagesGetSelectItems: 'images/list/getSelectItems',
        brandGetSelectItems: 'brand/list/getSelectItems',
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
