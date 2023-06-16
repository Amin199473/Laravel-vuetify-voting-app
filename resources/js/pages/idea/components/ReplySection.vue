<template>
    <div>
        <v-dialog transition="dialog-top-transition" width="500" v-model="dialog">
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    height="56"
                    width="120"
                    size="x-large"
                    color="primary"
                >
                    Reply
                </v-btn>
            </template>
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar
                        color="primary"
                        title="Leave Your Comment"
                    ></v-toolbar>
                    <v-card-text>
                        <v-textarea
                            v-if="userIsLoggedIn"
                            label="Leave Your Comment"
                            variant="solo-filled"
                            v-model="body"
                        ></v-textarea>
                        <div class="text-h6" v-else>
                            You should
                            <router-link to="/login" class="router-link"
                                >login/register</router-link
                            >
                            for adding comment
                        </div>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            v-if="userIsLoggedIn"
                            color="success"
                            @click="addComment()"
                            >Submit</v-btn
                        >
                        <v-btn color="error" @click="isActive.value = false"
                            >Close</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>

<script>
import alerts from "../../../alerts/index.js";
export default {
    data() {
        return {
            body: "",
            dialog:false
        };
    },
    computed: {
        userIsLoggedIn() {
            return this.$store.getters["Auth/isLoggedIn"];
        },
    },
    methods: {
        addComment() {
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .post(
                    `/add/comment/${slug}`,
                    {
                        body: this.body,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    this.dialog = false;
                    alerts.successAlert(response.data.message);
                })
                .catch((err) => {});
        },
    },
};
</script>

<style scoped>
.router-link {
    text-decoration: none;
    color: blue;
}
</style>
