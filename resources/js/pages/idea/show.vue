<template>
    <div>
        <div class="mb-3">
            <router-link to="/" class="route-link">
                <v-icon>mdi-arrow-left</v-icon>
                <span class="ml-2 font-weight-bold text-h6"> All Ideas </span>
            </router-link>
        </div>
        <v-card elevation="14" class="rounded-lg mb-8">
            <v-row>
                <v-col cols="12">
                    <div class="ml-5">
                        <v-avatar size="60" class="mt-4 rounded-lg">
                            <v-img
                                :src="RandomUrlImageFace()"
                                alt="John"
                            ></v-img>
                        </v-avatar>
                        <span class="ml-4 text-h5">{{ idea.title }}</span>
                        <p class="mt-3 pl-16 pr-2">
                            {{ idea.description }}
                        </p>
                    </div>
                    <div>
                        <div class="d-flex justify-space-around my-6">
                            <div>
                                <span class="mr-2">
                                    {{ idea.name }}
                                    <v-icon>mdi-circle-small</v-icon>
                                </span>
                                <span class="text-grey-lighten-1 mr-2">
                                    {{ idea.created_at }}
                                    <v-icon>mdi-circle-small</v-icon>
                                </span>
                                <span class="text-grey-lighten-1 mr-2">
                                    {{ idea.category
                                    }}<v-icon>mdi-circle-small</v-icon>
                                </span>
                                <span>{{ idea.commentsCount }} Comments</span>
                            </div>
                            <div class="justify-end">
                                <v-btn
                                    :style="{ 'background-color': idea.color }"
                                    class="rounded-xl text-white mr-2 font-weight-bold"
                                    width="130"
                                    max-height="40"
                                    variant="tonal"
                                >
                                    {{ idea.status }}
                                </v-btn>
                                <v-menu>
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            class="rounded-xl"
                                            width="60"
                                            max-height="40"
                                            variant="tonal"
                                        >
                                            <v-icon right size="x-large">
                                                mdi-dots-horizontal
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item>
                                            <v-btn
                                                variant="text"
                                                class="rounded-xl"
                                                width="120"
                                                max-height="20"
                                                @click="dialog = true"
                                            >
                                                Edit Idea
                                            </v-btn>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-btn
                                                variant="text"
                                                class="rounded-xl"
                                                width="120"
                                                max-height="20"
                                                @click="deleteDialog = true"
                                            >
                                                Delete Idea
                                            </v-btn>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-btn
                                                variant="text"
                                                class="rounded-xl"
                                                width="120"
                                                max-height="20"
                                            >
                                                Mark as Spam
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
        <v-row align="start" justify="space-between" no-gutters>
            <v-col cols="2">
                <ReplySection />
            </v-col>
            <v-col cols="2">
                <StatusSection v-if="isAdmin" :name="idea.status" />
            </v-col>
            <v-col cols="4"> </v-col>
            <v-col cols="4">
                <v-btn
                    class="mr-2 rounded-pill"
                    :disabled="true"
                    height="56"
                    width="120"
                    rouded-lg
                    size="x-large"
                >
                    {{ idea.votes }} Votes
                </v-btn>
                <v-btn
                    v-if="idea.isVotedbyUser"
                    class="rounded-xl bg-blue"
                    height="56"
                    width="120"
                    rouded-lg
                    size="x-large"
                    @click="userVote()"
                >
                    Voted
                </v-btn>
                <v-btn
                    v-else
                    class="rounded-xl"
                    height="56"
                    width="120"
                    rouded-lg
                    size="x-large"
                    @click="userVote()"
                >
                    Vote
                </v-btn>
            </v-col>
        </v-row>

        <!--Comment Card Section-->
        <CommentCard
            v-for="comment in comments"
            :key="comment.id"
            :id= comment.id
            :user="comment.user"
            :body="comment.body"
            :created_at="comment.created_at"
        />
        <!--Comment Card Section-->

        <v-row justify="center">
            <v-dialog v-model="dialog" persistent width="600">
                <v-card>
                    <v-card-title>
                        <span class="text-h5 text-center">Edit Your Idea</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="title"
                                        label="Your Idea"
                                        required
                                        variant="solo-filled"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        v-model="category"
                                        clearable
                                        label="Category"
                                        :items="categories"
                                        variant="solo-filled"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea
                                        v-model="description"
                                        clearable
                                        label="describe Your Idea"
                                        variant="solo-filled"
                                        bg-color="grey-lighten-2"
                                    ></v-textarea>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="dialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="editIdea()"
                        >
                            Edit
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

        <!--delete dialog-->
        <v-row justify="center">
            <v-dialog v-model="deleteDialog" persistent width="400">
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
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="deleteDialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="red-darken-1"
                            variant="text"
                            @click="deleteIdea()"
                        >
                            Delete
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>

<script>
import alerts from "../../alerts/index.js";
import CommentCard from "./components/CommentCard.vue";
import ReplySection from "./components/ReplySection.vue";
import StatusSection from "./components/StatusSection.vue";
export default {
    components: {
        CommentCard,
        ReplySection,
        StatusSection,
    },
    created() {
        this.getIdeaBySlug();
        this.getCommentsBySlug();
        this.getCategories();
    },
    data() {
        return {
            idea: {},
            dialog: false,
            deleteDialog: false,
            comments: [],
            category:'',
            description:'',
            title:'',
            categories:[]
        };
    },
    computed:{
        isAdmin() {
            let user =JSON.parse(this.$store.getters["Auth/getUser"]);
            if (user.isAdmin) {
                return true;
            }
            return false;
        },
    },
    methods: {
        RandomUrlImageFace() {
            let random = Math.floor(Math.random() * 1000 + 9000);
            let url = `https://ozgrozer.github.io/100k-faces/0/9/00${random}.jpg`;
            return url;
        },
        getCategories() {
            axios
                .get("/category")
                .then((response) => {
                    response.data.data.map((category) => {
                        this.categories.push({
                            id: category.id,
                            name: category.name,
                        });
                    });
                })
                .catch((error) => {});
        },
        getCommentsBySlug() {
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`/idea/comments/${slug}`, {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    response.data.data.map((comment) => {
                        this.comments.push({
                            id:comment.id,
                            user:comment.user,
                            body:comment.body,
                            created_at:comment.created_at,
                        })
                    });
                })
                .catch((error) => {});
        },
        getIdeaBySlug() {
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`/idea/${slug}`, {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    this.idea = response.data.data;
                })
                .catch((error) => {});
        },
        userVote() {
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`/idea/${slug}/vote/`, {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {});
        },
        editIdea(){
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .put(`/idea/${slug}`,
                {
                    title:this.title,
                    category : this.category,
                    description: this.description,
                },
                {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {});
        },
        deleteIdea(){
            let slug = this.$route.params.slug;
            let userToken = localStorage.getItem("userToken");
            axios
                .delete(`/idea/${slug}`, {
                    headers: {
                        Accept: "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    alerts.successAlert(response.data.message);
                })
                .catch((error) => {});
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
