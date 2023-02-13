import Vuex from "vuex";
import axios from "axios";

const state = {
    rooms_data: [],
    array_begin_data:[]
};

const actions = {
        LOAD_ROOMS_DATA({commit}) {
            const data_response = async () => {
                try {
                    const response = await axios.get('/api/get_rooms_data');
                    return response.data;
                } catch (error) {
                    throw new Error(error);
                }
            };
            data_response()
                .then(response => {
                    commit('SET_ROOMS_DATA', response);
                })
                .catch(error => {
                    console.log(error);
                });

          },
        LOAD_ARRAY_BEGIN_DATA({commit}) {

        }
    }
;

const mutations = {
    SET_ROOMS_DATA(state, rooms_data) {
        state.rooms_data = rooms_data;
    },
    SET_ARRAY_BEGIN_DATA(state, array_begin_data) {
        state.array_begin_data = array_begin_data;
    }
};

const getters = {
    rooms_data: state => {
        return state.rooms_data;
    },
    array_begin_data: state => {
        return state.array_begin_data;
    }
};

export default new Vuex.Store({
    namespaced: true,
    state,
    getters,
    actions,
    mutations
});
