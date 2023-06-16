import alerts from "../../../alerts/index.js";

export default {
    namespaced: true,
    state() {
        return {
            userIsLoggedIn: localStorage.getItem("userIsLoggedIn") || false,
            user: localStorage.getItem("userInfo") || "",
            userToken: localStorage.getItem("userToken") || "",
        };
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setUserLoggedIn(state, payload) {
            state.userIsLoggedIn = payload;
        },
        logout(state) {
            state.userToken = "";
        },
    },
    actions: {
        userRegister({ commit }, payload) {
            axios
                .post(`register/`, payload)
                .then((response) => {
                    console.log(response.data);
                    const userToken =
                        "Bearer " + response.data.token.original.access_token;
                    const user = response.data.user;
                    localStorage.setItem("userIsLoggedIn", true);
                    localStorage.setItem("userToken", userToken);
                    localStorage.setItem("userInfo", JSON.stringify(user));
                    commit("setUser", user);
                    commit("setUserLoggedIn", true);
                    alerts.successAlert("You successfully registered");
                })
                .catch((error) => {
                    localStorage.removeItem("userIsLoggedIn");
                    localStorage.removeItem("userToken");
                    localStorage.removeItem("userInfo");
                    alerts.errorAlert("You are not successfully registered");
                });
        },
        userLogin({ commit }, payload) {
            axios
                .post(`login/`, payload)
                .then((response) => {
                    const userToken = "Bearer " + response.data.access_token;
                    const user = response.data.user;
                    localStorage.setItem("userIsLoggedIn", true);
                    localStorage.setItem("userToken", userToken);
                    localStorage.setItem("userInfo", JSON.stringify(user));
                    commit("setUser", user);
                    commit("setUserLoggedIn", true);
                    alerts.successAlert("you Successfully logged in");
                })
                .catch((error) => {
                    localStorage.removeItem("userIsLoggedIn");
                    localStorage.removeItem("userToken");
                    localStorage.removeItem("userInfo");
                    alerts.errorAlert("something not correct try again");
                });
        },
         userLogout({ commit }) {
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`logout/`, {
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": userToken,
                    },
                })
                .then((response) => {
                    commit("setUser", {});
                    commit("setUserLoggedIn", false);
                    commit("logout");
                    localStorage.removeItem("userIsLoggedIn");
                    localStorage.removeItem("userToken");
                    localStorage.removeItem("userInfo");
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {
                    alerts.errorAlert("something not correct try again");
                });
        },
    },
    getters: {
        // isIn: (state) => !!state.userToken,
        isLoggedIn(state) {
            return !!state.userToken;
        },
        // getUser: (state) => state.user,
        getUser(state) {
            return state.user;
        },
    },
};
