import * as types from "./mutation_types";

export default {
  [types.IMAGE_DELETE_SET_DELETED](state, deleted) {
    Object.assign(state, { deleted });
  },

  [types.IMAGE_DELETE_SET_ERROR](state, error) {
    Object.assign(state, { error });
  },

  [types.IMAGE_DELETE_TOGGLE_LOADING](state) {
    Object.assign(state, { error: "", isLoading: !state.isLoading });
  },

  [types.IMAGE_DELETE_RESET](state) {
    Object.assign(state, {
      deleted: null,
      error: "",
      isLoading: false,
    });
  },
};
