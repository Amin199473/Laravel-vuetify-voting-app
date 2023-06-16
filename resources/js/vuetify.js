// Vuetify
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'light'
    },
    breakpoint: {
        thresholds: {
            xs: 340,
            sm: 540,
            md: 800,
            lg: 1280,
        },
    },
    components,
    directives,
});

export default vuetify;
