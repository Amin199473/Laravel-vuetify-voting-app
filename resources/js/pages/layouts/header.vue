<template>
    <div>
        <v-app-bar :elevation="6">
            <v-container>
                <v-row align="end">
                    <v-col cols="12" md="4" no-gutters>
                        <v-icon size="58" color="orange-darken-4"
                            >mdi-laravel</v-icon
                        >
                    </v-col>
                    <v-col cols="12" md="2"> </v-col>
                    <v-col cols="12" md="6" align="end">
                        <v-btn
                            @click="logout"
                            size="small"
                            class="bg-red text-white mr-1"
                        >
                            Logout
                            <v-icon size="20">mdi-logout</v-icon>
                        </v-btn>
                        <router-link class="router-link" to="/login" v-if="!userIsLoggedIn">
                            <v-btn size="small" class="bg-blue text-white mr-1">
                                Login
                                <v-icon size="20">mdi-login</v-icon>
                            </v-btn>
                        </router-link>
                        <router-link class="router-link" to="/register">
                            <v-btn size="small" class="bg-green text-white">
                                Register
                                <v-icon size="20">mdi-account</v-icon>
                            </v-btn>
                        </router-link>
                    </v-col>
                </v-row>
            </v-container>
        </v-app-bar>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    computed: {
        userIsLoggedIn() {
            return this.$store.getters["Auth/isLoggedIn"];
        },
    },
    methods: {
        logout() {
            this.$store.dispatch("Auth/userLogout");
            return this.$router.push("/login");
        },
    },
};
</script>
<style scoped>
.logo-text {
    font-size: 32px;
    font-weight: bold;
    margin-left: 10px;
}
.router-link {
    text-decoration: none;
}
</style>
