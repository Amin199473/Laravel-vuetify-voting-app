<template>
    <div>
        <v-app>
            <TheHeader />
            <v-main>
                <v-container class="mt-10">
                    <div v-if="checkCurrentPath">
                        <v-row justify="space-around">
                            <v-col cols="3">
                                <IdeaForm />
                            </v-col>
                            <v-col cols="9">
                                <router-view></router-view>
                            </v-col>
                        </v-row>
                    </div>
                    <div v-else>
                        <router-view></router-view>
                    </div>
                </v-container>
            </v-main>
            <TheFooter />
        </v-app>
    </div>
</template>

<script>
import TheHeader from "./layouts/header.vue";
import TheFooter from "./layouts/footer.vue";
import IdeaForm from "./layouts/IdeaForm.vue";
export default {
    components: {
        TheHeader,
        TheFooter,
        IdeaForm,
    },
    data() {
        return {};
    },
    computed: {
        checkCurrentPath() {
            if (this.$route.path != "/register" && this.$route.path != "/login") {
                return true;
            }
            return false;
        },
    },
};
</script>


