import http from "@/inc/Http";

const defaultState = () => {
  return {
    user: [],
    token: "",
  };
};

export default {
  namespaced: true,
  state() {
    return {
      user: [],
    };
  },
  mutations: {
    async checkUser(state) {
      if (localStorage.getItem("user")) {
        const user = await JSON.parse(localStorage.getItem("user"));
        state.user = user;
      }
    },
    setUser(state, user) {
      localStorage.setItem("user", JSON.stringify(user.user));
      localStorage.setItem("token", user.token);
      state.user = user.user;
      state.token = user.token;
    },
    setData(state) {
      state.user = JSON.parse(localStorage.getItem("user"));
      state.token = localStorage.getItem("token");
    },
    resetState(state) {
      Object.assign(state, defaultState());
    },
  },
  getters: {
    checkLogin() {
      if (localStorage.getItem("user") === null) return false;
      return JSON.parse(localStorage.getItem("user"));
    },
  },
  actions: {
    setData(context) {
      if (localStorage.getItem("token")) {
        context.commit("setData");
      }
    },
    setUser(context, user) {
      context.commit("setUser", user);
    },
    doRegister(context, user) {
      http.post("u/register", user).then(({ data }) => {
        if (data) {
          if (!localStorage.getItem("user")) context.commit("setUser", data);
          return true;
        }
      });
    },
    resetState({ commit }) {
      commit("resetState");
    },
  },
};
