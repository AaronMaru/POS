import Vue from 'vue';
import Vuex from 'vuex';

import { getAllProducts } from './api';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    products: [],
    items: [],
    total: 0,
    totalRows: null
  },
  getters: {
    products: state => state.products,
    items: state => state.items,
    total: state => state.total,
    totalRows: state => state.totalRows,
  },
  mutations: {
    ADD_ITEM(state, item) {
      let found = state.items.findIndex(each => each.id == item.id);
      if (found >= 0) {
        state.items[found].qty += 1;
      } else {
        item.qty = 1;
        state.items.push(item);
      }
    },
    REMOVE_ITEM(state, item) {
      let found = state.items.findIndex(each => each.id == item.id);
      if (found >= 0) {
        state.items.splice(found, 1);
      }
    },
    UPDATE_ITEM(state, item) {
      let found = state.items.findIndex(each => each.id == item.id);
      if (found >= 0) {
        state.items[found].qty = item.qty;
      }
    },
    CLEAR_ALL_ITEMS(state) {
      state.items = [];
      state.total = 0;
    },
    TOTAL_ITEM_PRICE(state) {
      let total = 0;
      state.items.map(each => {
        each.subTotal = parseInt(each.qty) * parseFloat(each.sale_price);
        total += parseFloat(each.subTotal);
      });
      state.total = total;
      return state.total;
    },
    LIST_PRODUCTS(state, query) {
        console.log("name store", query);
        getAllProducts(query).then(res => {
            state.products = res.data.data;
            state.totalRows = res.data.meta.total;
      });
    },
  },
  actions: {
    addItem(ctx, item) {
      ctx.commit('ADD_ITEM', item);
      ctx.commit('TOTAL_ITEM_PRICE');
    },
    removeItem(ctx, item) {
      ctx.commit('REMOVE_ITEM', item);
      ctx.commit('TOTAL_ITEM_PRICE');
    },
    updateItem(ctx, item) {
      ctx.commit('UPDATE_ITEM', item);
      ctx.commit('TOTAL_ITEM_PRICE');
    },
    clearAllItems(ctx) {
      ctx.commit('CLEAR_ALL_ITEMS');
    },
    listProduct(ctx, query = {}) {
        console.log("listParam: ", query);
        ctx.commit('LIST_PRODUCTS', query);
    },
    totalItemPrice(ctx) {
      ctx.commit('TOTAL_ITEM_PRICE');
    }
  },
});
