<template>
    <v-card elevation="14" class="rounded-lg mb-8">
        <v-row>
            <v-col cols="2" class="mr-n3">
                <div class="d-flex flex-column align-center pt-4">
                    <p class="text-h5">{{ votes }}</p>
                    <p class="text-subtitle-2">votes</p>
                    <v-btn v-if="isVotedbyUser" size="default" class="mt-10 rounded-xl text-center text-white bg-blue"
                        variant="tonal" @click="userVote()">
                        voted
                    </v-btn>
                    <v-btn v-else size="default" class="mt-10 rounded-xl text-center" variant="tonal" @click="userVote()">
                        vote
                    </v-btn>
                </div>
            </v-col>
            <v-divider vertical></v-divider>
            <v-col cols="10">
                <div class="ml-1">
                    <v-avatar size="60" class="mt-4 rounded-lg">
                        <v-img :src="RandomUrlImageFace()" alt="John"></v-img>
                    </v-avatar>
                    <router-link :to="{ name: 'ideaShow', params: { slug: slug } }" class="router-link">
                        <span class="ml-4 text-h5">{{ title }}</span>
                    </router-link>
                    <p class="mt-3 pl-16 pr-2">
                        {{ description }}
                    </p>
                </div>
                <div>
                    <div class="d-flex justify-space-around my-6">
                        <div>
                            <span class="mr-2">
                                {{ name }}<v-icon>mdi-circle-small</v-icon>
                            </span>
                            <span class="text-grey-lighten-1 mr-2">
                                {{ created_at }}<v-icon>mdi-circle-small</v-icon>
                            </span>
                            <span class="text-grey-lighten-1 mr-2">
                                {{ category }}<v-icon>mdi-circle-small</v-icon>
                            </span>
                            <span>{{ commentsCount }} Comments</span>
                        </div>
                        <div class="justify-end">
                            <v-btn
                                :style="{ 'background-color': color }"
                                class="rounded-xl text-white mr-2 font-weight-bold"
                                width="130" max-height="40"
                                variant="tonal">
                                {{ status }}
                            </v-btn>
                            <v-menu>
                                <template v-slot:activator="{ props }">
                                    <v-btn v-bind="props" class="rounded-xl" width="60" max-height="40" variant="tonal">
                                        <v-icon right size="x-large">mdi-dots-horizontal</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-list-item>
                                        <v-btn variant="text" class="rounded-xl" width="120" max-height="20">
                                            Mark as Spam
                                        </v-btn>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-btn variant="text" class="rounded-xl" width="120" max-height="20">
                                            Delete Post
                                        </v-btn>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import alerts from "../../alerts/index.js";
export default {
    props: {
        id: { type: Number, required: true },
        name: { type: String, required: true },
        category: { type: String, required: true },
        status: { type: String, required: true },
        votes: { type: Number, required: true },
        commentsCount: { type: Number, required: true },
        color: { type: String, required: true },
        title: { type: String, required: true },
        isVotedbyUser: { type: Boolean, required: true },
        description: { type: String, required: true },
        slug: { type: String, required: true },
        created_at: { type: String, required: true },
    },
    data() {
        return {};
    },
    methods: {
        RandomUrlImageFace() {
            let random = Math.floor(Math.random() * 1000 + 9000);
            let url = `https://ozgrozer.github.io/100k-faces/0/9/00${random}.jpg`;
            return url;
        },
        userVote() {
            if (this.$store.getters["Auth/isLoggedIn"]) {
                let userToken = localStorage.getItem("userToken");
                axios
                    .get(`idea/${this.id}/vote`, {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    })
                    .then((response) => {
                        alerts.successAlert(response.data.message);
                    })
                    .catch((err) => { });

                return true;
            }
            return this.$router.push("/login");
        },
    },
};
</script>

<style>
.router-link {
    text-decoration: none;
    color: black;
}

.router-link:hover {
    color: blue;
}
</style>
