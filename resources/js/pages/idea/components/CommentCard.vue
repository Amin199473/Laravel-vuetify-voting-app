<template>
    <div>
        <v-row align="start" class="mt-8">
            <v-timeline side="end">
                <v-timeline-item size="small" dot-color="info">
                    <v-card elevation="14" class="rounded-lg left-border">
                        <v-row>
                            <v-col cols="12">
                                <div class="ml-5 d-flex align-start">
                                    <div class="mt-4">
                                        <v-avatar size="60" class="rounded-lg">
                                            <v-img
                                                :src="RandomUrlImageFace()"
                                                alt="John"
                                            ></v-img>
                                        </v-avatar>
                                    </div>
                                    <div class="mt-4">
                                        <p class="px-4">
                                            {{ body }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="d-flex justify-space-between my-6 mx-5"
                                    >
                                        <div>
                                            <span class="mr-2">
                                                {{ user }}
                                                <v-icon
                                                    >mdi-circle-small</v-icon
                                                >
                                            </span>
                                            <span
                                                class="text-grey-lighten-1 mr-2"
                                            >
                                                {{ created_at }}
                                                <v-icon
                                                    mdi-circle-small
                                                ></v-icon>
                                            </span>
                                        </div>
                                        <div
                                            class="justify-end"
                                            style="margin-left: 100px"
                                        >
                                            <v-menu>
                                                <template
                                                    v-slot:activator="{ props }"
                                                >
                                                    <v-btn
                                                        v-bind="props"
                                                        class="rounded-xl"
                                                        width="60"
                                                        max-height="20"
                                                        variant="tonal"
                                                    >
                                                        <v-icon right
                                                            >mdi-dots-horizontal</v-icon
                                                        >
                                                    </v-btn>
                                                </template>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-dialog
                                                            transition="dialog-top-transition"
                                                            width="500"
                                                            v-model="dialog"
                                                        >
                                                            <template
                                                                v-slot:activator="{
                                                                    props,
                                                                }"
                                                            >
                                                                <v-btn
                                                                    v-bind="
                                                                        props
                                                                    "
                                                                    variant="text"
                                                                    class="rounded-xl"
                                                                    width="120"
                                                                    max-height="20"
                                                                >
                                                                    Edit Comment
                                                                </v-btn>
                                                            </template>
                                                            <template
                                                                v-slot:default="{
                                                                    isActive,
                                                                }"
                                                            >
                                                                <v-card>
                                                                    <v-toolbar
                                                                        color="primary"
                                                                        title="Edit Your Comment"
                                                                    >
                                                                    </v-toolbar>
                                                                    <v-card-text>
                                                                        <v-textarea
                                                                            v-model="
                                                                                comment
                                                                            "
                                                                            label="Leave Your Comment"
                                                                            variant="solo-filled"
                                                                        >
                                                                        </v-textarea>
                                                                    </v-card-text>
                                                                    <v-card-actions
                                                                        class="justify-end"
                                                                    >
                                                                        <v-btn
                                                                            v-if="
                                                                                userIsLoggedIn
                                                                            "
                                                                            color="success"
                                                                            @click="
                                                                                editComment()
                                                                            "
                                                                            >Submit
                                                                        </v-btn>
                                                                        <v-btn
                                                                            color="error"
                                                                            @click="
                                                                                isActive.value = false
                                                                            "
                                                                        >
                                                                            Close
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                </v-card>
                                                            </template>
                                                        </v-dialog>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-dialog
                                                            transition="dialog-top-transition"
                                                            width="500"
                                                            v-model="deleteDialog"
                                                        >
                                                            <template
                                                                v-slot:activator="{
                                                                    props,
                                                                }"
                                                            >
                                                                <v-btn
                                                                    v-bind="
                                                                        props
                                                                    "
                                                                    variant="text"
                                                                    class="rounded-xl"
                                                                    width="120"
                                                                    max-height="20"
                                                                >
                                                                    delete Comment
                                                                </v-btn>
                                                            </template>
                                                            <template
                                                                v-slot:default="{
                                                                    isActive,
                                                                }"
                                                            >
                                                                <v-card>
                                                                    <v-toolbar
                                                                        color="red-darken-3"
                                                                        title="Are you sure for delete?"
                                                                    ></v-toolbar>
                                                                    <v-card-text>
                                                                        <div class="text-h5 pa-12">
                                                                            Are you sure for delete this Idea?
                                                                        </div>
                                                                    </v-card-text>
                                                                    <v-card-actions
                                                                        class="justify-end"
                                                                    >
                                                                        <v-btn
                                                                            v-if="
                                                                                userIsLoggedIn
                                                                            "
                                                                            color="success"
                                                                            @click="
                                                                                deleteComment()
                                                                            "
                                                                            >Submit
                                                                        </v-btn>
                                                                        <v-btn
                                                                            color="error"
                                                                            @click="
                                                                                isActive.value = false
                                                                            "
                                                                        >
                                                                            Close
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                </v-card>
                                                            </template>
                                                        </v-dialog>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-timeline-item>
            </v-timeline>
        </v-row>
    </div>
</template>

<script>
import alerts from "../../../alerts/index.js";
export default {
    props: {
        id: { type: Number, required: true },
        user: { type: String, required: true },
        body: { type: String, required: true },
        created_at: { type: String, required: true },
        updated_at: { type: String, required: false },
    },
    data() {
        return {
            dialog: false,
            deleteDialog: false,
            comment: this.body,
        };
    },
    methods: {
        RandomUrlImageFace() {
            let random = Math.floor(Math.random() * 1000 + 9000);
            let url = `https://ozgrozer.github.io/100k-faces/0/9/00${random}.jpg`;
            return url;
        },
        userIsLoggedIn() {
            let user = JSON.parse(this.$store.getters["Auth/getUser"]);
            if (user.isAdmin) {
                return true;
            }
            return false;
        },
        editComment() {
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .put(
                    `/comment/${this.id}`,
                    {
                        comment: this.comment,
                        slug: slug,
                    },
                    {
                        headers: {
                            Accept: "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    this.dialog = false;
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {});
        },
        deleteComment() {
            let userToken = localStorage.getItem("userToken");
            axios
                .delete(`/comment/${this.id}`, {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    this.deleteDialog = false;
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {});
        },
    },
};
</script>

<style scoped>
.left-border {
    margin-right: 20px;
    border-left: 2px solid red;
}
</style>
