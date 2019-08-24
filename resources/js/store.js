import Vuex from 'vuex';
import 'babel-polyfill'
import axiosRequest from "./axiosRequest";

window.Vue = require('vue');
Vue.use(Vuex);

export default new Vuex.Store({

    state: {
        Books: {}
    },

    getters: {
        Books: state => state.Books
    },

    mutations: {
        SET_BOOK(state, data) {
            state.Books = data.data
            console.log(state.Books)
        }
    },

    actions: {
        loadData: async (context) => {
            const data = await axiosRequest.get('/api/books')
            context.commit('SET_BOOK', data)
        }

    }
})
