import { createStore } from 'vuex'

import AuthModules from "./modules/Auth/index.js";

const store = createStore({
    modules: {
        Auth: AuthModules,
    },
})
export default store;
