import {createStore} from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {
                name: 'John',
                token: null
            }
        },
        dashboard: {
            loading: false,
            data: {}
        },
        shorteners: {
            loading: false,
            links: [{"url": "link"}],
            data: []
        },
        currentShortener: {
            data: {},
            loading: false,
        },
        notification: {
            show: false,
            type: 'success',
            message: ''
        }
    },

    getters: {},

    actions: {
        getShorteners({ commit }, {url = null} = {}) {
            commit('setShortenersLoading', true)
            url = url || "/shorteners";
            return axiosClient.get(url).then((res) => {
                commit('setShortenersLoading', false)
                commit("setShorteners", res.data);
                // debugger
                return res;
            });
        },
        getShortener({ commit }, id) {
            commit("setCurrentShortenerLoading", true);
            return axiosClient
                .get(`/shorteners/${id}`)
                .then((res) => {
                commit("setCurrentShortener", res.data);
                commit("setCurrentShortenerLoading", false);
            return res;
            })
                .catch((err) => {
                commit("setCurrentShortenerLoading", false);
            throw err;
            });
        },
        saveShortener({ commit, dispatch }, shortener) {
      
            let response;
            if (shortener.shortenedUrl.length) {
              response = axiosClient
                .put(`/shorteners/${shortener.identifier}`, { url: shortener.url, title: shortener.title})
                .then((res) => {
                  commit('setCurrentShortener', res.data)
                  return res;
                });
            } else {
              response = axiosClient.post("/shorteners", shortener).then((res) => {
                commit('setCurrentShortener', res.data)
                return res;
              });
            }
      
            return response;
        },
        deleteShortener({ dispatch }, id) {
            console.log('id', id)
            return axiosClient.delete(`/shorteners/${id}`).then((res) => {
                dispatch('getShorteners')
                return res;
            });
        },
    },

    mutations: {
        setShortenersLoading: (state, loading) => {
            state.shorteners.loading = loading;
        },
        setShorteners: (state, shorteners) => {
            state.shorteners.links = shorteners.meta.links;
            state.shorteners.data = shorteners.data;
        },
        setCurrentShortenerLoading: (state, loading) => {
            state.currentShortener.loading = loading;
        },
        setCurrentShortener: (state, shortener) => {
            state.currentShortener.data = shortener.data;
        },
        notify: (state, {message, type}) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
              state.notification.show = false;
            }, 3000)
        },        
    },

    modules: {},
})

export default store