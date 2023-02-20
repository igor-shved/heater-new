import Vuex from "vuex";
import axios from "axios";
import data from "bootstrap/js/src/dom/data";

const state = {
    roomsData: [],
    arrayInitData: [],
    isLoadInitData: false,
    isLoadRoomsData: false
};

const axios_async = async (req_url) => {
    try {
        const response = await axios.get(req_url);
        return response.data;
    } catch (error) {
        throw new Error(error);
    }
}

const actions = {
        LOAD_ROOMS_DATA({commit}, req_url) {
            // axios_async(req_url)
            //     .then(data => {
            //         commit('SET_ROOMS_DATA', data);
            //     })
            //     .catch(error => {
            //         console.log(error);
            //         commit('SET_ROOMS_DATA', []);
            //     });
            axios.get(req_url)
                .then(response => {
                    commit('SET_ROOMS_DATA', response.data);
                    commit('SET_IS_LOAD_ROOMS_DATA', true);
                })
                .catch(error => {
                    console.log(error);
                    commit('SET_ROOMS_DATA', []);
                })
        },
        LOAD_ARRAY_INIT_DATA({commit}, req_url) {
            axios.get(req_url)
                .then(response => {
                    commit('SET_ARRAY_INIT_DATA', response.data);
                    commit('SET_IS_LOAD_INIT_DATA', true);
                })
                .catch(error => {
                    console.log(error);
                    commit('SET_ARRAY_INIT_DATA', []);
                })
        }
    }
;

const mutations = {
    SET_ROOMS_DATA(state, roomsData) {
        state.roomsData = roomsData;
    },
    SET_ARRAY_INIT_DATA(state, arrayInitData) {
        state.arrayInitData = arrayInitData;
    },
    SET_IS_LOAD_INIT_DATA(state, value) {
        state.isLoadInitData = value;
    },
    SET_IS_LOAD_ROOMS_DATA(state, value) {
        state.isLoadRoomsData = value;
    }
};

const getters = {
    roomsData: state => {
        return state.roomsData;
    },
    arrayInitData: state => {
        return state.arrayInitData;
    },
    isLoadInitData: state => {
        return state.isLoadInitData;
    },
    isLoadRoomsData: state => {
        return state.isLoadRoomsData;
    },

};

export default new Vuex.Store({
    namespaced: true,
    state,
    getters,
    actions,
    mutations
});
