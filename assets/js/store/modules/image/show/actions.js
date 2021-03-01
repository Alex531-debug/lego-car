import fetch from "../../../../utils/fetch";
import * as types from "./mutation_types";

import { ENTRYPOINT } from './../../../../config/entrypoint';

export const retrieve = ({ commit }, id) => {
  commit(types.IMAGE_SHOW_TOGGLE_LOADING);

  return fetch(ENTRYPOINT+id)
    .then((response) => response.json())
    .then((data) => {
      commit(types.IMAGE_SHOW_TOGGLE_LOADING);
      commit(types.IMAGE_SHOW_SET_RETRIEVED, data);
    })
    .catch((e) => {
      commit(types.IMAGE_SHOW_TOGGLE_LOADING);
      commit(types.IMAGE_SHOW_SET_ERROR, e.message);
    });
};

export const reset = ({ commit }) => {
  commit(types.IMAGE_SHOW_RESET);
};
