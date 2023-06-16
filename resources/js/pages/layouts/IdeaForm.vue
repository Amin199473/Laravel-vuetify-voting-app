<template>
    <div>
        <v-card elevation="14">
            <v-card-item class="text-center">
                <v-card-title>Add an Idea</v-card-title>

                <p v-if="userIsLoggedIn">
                    Let us know what you would like and we'll take a look over!
                </p>
                <p v-else>
                    For Create Idea You should
                    <router-link to="/login" class="router-link"
                        >Login</router-link
                    >
                </p>
            </v-card-item>

            <v-form>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model="title"
                                clearable
                                label="Your Idea"
                                variant="solo-filled"
                                :rules="rules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-select
                                v-model="category"
                                clearable
                                label="Category"
                                :items="categories"
                                item-value="id"
                                item-title="name"
                                variant="solo-filled"
                                return-object
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-textarea
                                v-model="description"
                                clearable
                                label="describe Your Idea"
                                variant="solo-filled"
                                bg-color="grey-lighten-2"
                                :rules="rules"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="7">
                            <v-file-input
                                class="rounded-lg"
                                prepend-icon=""
                                label="Attach"
                                variant="solo-filled"
                            ></v-file-input>
                        </v-col>
                        <v-col cols="5">
                            <v-btn
                                :disabled="!userIsLoggedIn"
                                class="rounded-lg"
                                color="success"
                                size="x-large"
                                @click="createYourIdea"
                            >
                                Submit
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
import alerts from "../../alerts/index.js";
export default {
    created() {
        this.getCategories();
    },
    data() {
        return {
            categories: [],
            title: "",
            category: "",
            description: "",
            rules: [(value) => !!value || "Required."],
        };
    },
    computed: {
        userIsLoggedIn() {
            return this.$store.getters["Auth/isLoggedIn"];
        },
    },
    methods: {
        test(){
            alert("dada");
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
        createYourIdea() {
            let userToken = localStorage.getItem("userToken");
            axios
                .post(
                    "idea/store",
                    {
                        title: this.title,
                        category_id: this.category.id,
                        description: this.description,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    alerts.successAlert(response.data.message);
                    this.$router.push("/");
                })
                .catch((error) => {
                    alerts.errorAlert("your Idea not been created");
                });
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
