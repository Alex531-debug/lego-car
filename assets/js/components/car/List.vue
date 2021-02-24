<template>
  <div>
    <h1>Список автомобилей</h1>
    <div
      v-if="isLoading"
      class="alert alert-info">Loading...</div>
    <div
      v-if="deletedItem"
      class="alert alert-success">{{ deletedItem['@id'] }} deleted.</div>
    <div
      v-if="error"
      class="alert alert-danger">{{ error }}</div>
    <p>
      <router-link
        :to="{ name: 'CarCreate' }"
        class="btn btn-primary">Create</router-link>
    </p>

    <table class="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>название</th>
          <th>моедль</th>
          <th>vin</th>
          <th>цена</th>
          <th>статус</th>
          <th>изображения</th>
          <th>brand</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item['@id']">
          <td>
              {{ item['name'] }}
          </td>
          <td>
              {{ item['model'] }}
          </td>
          <td>
              {{ item['vin'] }}
          </td>
          <td>
              {{ item['price'] }}
          </td>
          <td>
              {{ prepareStatus(item['status']) }}
          </td>
          <td>
              <template>
                <div
                  v-if="Array.isArray(item['images'])">
                  <router-link
                    v-for="link in item['images']"
                    :key="link['@id']"
                    :to="{ name: 'ImageShow', params: { id: link['@id'] } }">
                    {{ link['@id'] }}
                  </router-link>
                </div>
                <router-link
                  v-else
                  :to="{ name: 'ImageShow', params: { id: item['images'] } }">
                  {{ item['images'] }}
                </router-link>
              </template>
          </td>
          <td>
              <template>
                <div
                  v-if="Array.isArray(item['brands'])">
                  <router-link
                    v-for="link in item['brands']"
                    :key="link['@id']"
                    :to="{ name: 'BrandShow', params: { id: link['@id'] } }">
                    {{ link['@id'] }}
                  </router-link>
                </div>
                <router-link
                  v-else
                  :to="{ name: 'BrandShow', params: { id: item['brands'] } }">
                  {{ item['brands'] }}
                </router-link>
              </template>
          </td>
          <td>
            <router-link
              :to="{name: 'CarShow', params: { id: item['@id'] }}">
              <span
                class="fa fa-search"
                aria-hidden="true"></span>
              <span class="sr-only">Show</span>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <nav aria-label="Page navigation" v-if="view">
      <router-link
        :to="view['hydra:first'] ? view['hydra:first'] : 'CarContactList'"
        :class="{ disabled: !view['hydra:previous'] }"
        class="btn btn-primary">
        <span aria-hidden="true">&lArr;</span> First
      </router-link>
      &nbsp;
      <router-link
        :to="!view['hydra:previous'] || view['hydra:previous'] === view['hydra:first'] ? 'CarList' : view['hydra:previous']"
        :class="{ disabled: !view['hydra:previous'] }"
        class="btn btn-primary">
        <span aria-hidden="true">&larr;</span> Previous
      </router-link>

      <router-link
        :to="view['hydra:next'] ? view['hydra:next'] : '#'"
        :class="{ disabled: !view['hydra:next'] }"
        class="btn btn-primary">
        Next <span aria-hidden="true">&rarr;</span>
      </router-link>

      <router-link
        :to="view['hydra:last'] ? view['hydra:last'] : '#'"
        :class="{ disabled: !view['hydra:next'] }"
        class="btn btn-primary">
        Last <span aria-hidden="true">&rArr;</span>
      </router-link>
    </nav>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import { mapFields } from 'vuex-map-fields';

export default {
  name: "CarList",
  computed: {
      ...mapFields('car/del', {
          deletedItem: 'deleted',
      }),
      ...mapFields('car/list', {
          error: 'error',
          items: 'items',
          isLoading: 'isLoading',
          view: 'view',
      }),
  },

  mounted() {
    this.getPage();
  },

  methods: {
    ...mapActions({
      getPage: 'car/list/default',
    }),
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
