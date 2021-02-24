import * as types from "./mutation_types";

export default {
  [types.IMAGE_SHOW_RESET](state) {
    Object.assign(state, {
      error: "",
      isLoading: false,
      retrieved: null,
    });
  },

  [types.IMAGE_SHOW_SET_ERROR](state, error) {
    Object.assign(state, { error });
  },

  [types.IMAGE_SHOW_SET_RETRIEVED](state, retrieved) {
    Object.assign(state, { retrieved });
  },

  [types.IMAGE_SHOW_TOGGLE_LOADING](state) {
    Object.assign(state, { error: "", isLoading: !state.isLoading });
  },
};
