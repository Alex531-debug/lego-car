import fetch from "../../../../utils/fetch";
import * as types from "./mutation_types";
import { ENTRYPOINT } from './../../../../config/entrypoint';


const getItems = ({ commit }, page = "cars") => {

    console.log(page);

  commit(types.TOGGLE_LOADING);
  fetch(ENTRYPOINT+page)
    .then((response) => response.json())
    .then((data) => {
      commit(types.TOGGLE_LOADING);
      commit(types.SET_ITEMS, data["hydra:member"]);
      commit(types.SET_VIEW, data["hydra:view"]);
    })
    .catch((e) => {
      commit(types.TOGGLE_LOADING);
      commit(types.SET_ERROR, e.message);
    });
};

export const getSelectItems = (
  { commit },
  { page = "cars", params = { properties: ["@id", "name"] } } = {}
) => {
  commit(types.TOGGLE_LOADING);
  fetch(ENTRYPOINT+page, { params })
    .then((response) => response.json())
    .then((data) => {
      commit(types.TOGGLE_LOADING);
      commit(types.SET_SELECT_ITEMS, data["hydra:member"]);
    })
    .catch((e) => {
      commit(types.TOGGLE_LOADING);
      commit(types.SET_ERROR, e.message);
    });
};

export default getItems;
