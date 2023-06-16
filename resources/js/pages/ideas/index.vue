<template>
    <v-container>
        <v-row class="mb-4">
            <v-col cols="12">
                <v-card>
                    <v-tabs
                        v-model="tab_1"
                        bg-color="purple-lighten-1"
                        align-tabs="center"
                    >
                        <v-tab value="one" size="small" @click="ideaPaginate()">
                            All IDEAS({{ countAllIdeas }})
                        </v-tab>
                        <v-tab
                            value="two"
                            size="small"
                            @click="
                                filteringIdeasBasedOnTheirStatuses(
                                    'Considering'
                                )
                            "
                        >
                            CONSIDERING({{ consideringIdeas }})
                        </v-tab>
                        <v-tab
                            value="three"
                            size="small"
                            @click="
                                filteringIdeasBasedOnTheirStatuses(
                                    'In Progress'
                                )
                            "
                        >
                            IN PROGRESS({{ inProgressIdeas }})
                        </v-tab>
                        <v-tab
                            value="four"
                            size="small"
                            @click="
                                filteringIdeasBasedOnTheirStatuses(
                                    'Implemented'
                                )
                            "
                        >
                            IMPLEMENTED IDEAS({{ implementedIdeas }})
                        </v-tab>
                        <v-tab
                            value="five"
                            size="small"
                            @click="
                                filteringIdeasBasedOnTheirStatuses('Closed')
                            "
                        >
                            CLOSED({{ closedIdeas }})
                        </v-tab>
                    </v-tabs>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="3">
                <v-select
                    v-model="category"
                    clearable
                    label="Category"
                    :items="categories"
                    item-value="id"
                    item-title="name"
                    variant="solo-filled"
                    return-object
                    @update:modelValue="filteringIdeasBasedOnTheirCategories()"
                >
                </v-select>
            </v-col>
            <v-col cols="3">
                <v-select
                    v-model="otherFilters"
                    clearable
                    label="Other Filters"
                    :items="['No Filter', 'Top Voted', 'My Ideas']"
                    variant="solo-filled"
                    @update:modelValue="filteringIdeasBasedOnOtherFilters()"
                ></v-select>
            </v-col>
            <v-col cols="6">
                <v-text-field
                    v-model="search"
                    prepend-icon="mdi-magnify"
                    clearable
                    label="Find an Idea"
                    variant="solo-filled"
                    @input="filteringIdeasBasedOnIdeaTitle()"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" v-for="idea in ideas" :key="idea.id">
                <VotingCardSection
                    :id="idea.id"
                    :name="idea.name"
                    :category="idea.category"
                    :status="idea.status"
                    :votes="idea.votes"
                    :commentsCount="idea.commentsCount"
                    :color="idea.color"
                    :isVotedbyUser="idea.isVotedbyUser"
                    :title="idea.title"
                    :description="idea.description"
                    :slug="idea.slug"
                    :created_at="idea.created_at"
                />
            </v-col>
        </v-row>
        <div class="text-center">
            <v-pagination
                v-model="pagination.current"
                :length="pagination.total"
                @click="onPageChange"
            ></v-pagination>
        </div>
    </v-container>
</template>

<script>
import VotingCardSection from "../components/VotingCard.vue";
export default {
    created() {
        this.getCategories();
        this.ideaPaginate();
        this.ideaCountBasedOntheirStatus();
    },
    components: {
        VotingCardSection,
    },
    data: () => ({
        tab_1: null,
        countAllIdeas: "",
        search: "",
        status: "",
        otherFilters: "",
        consideringIdeas: "",
        inProgressIdeas: "",
        implementedIdeas: "",
        categories: [],
        category: "",
        closedIdeas: "",
        ideas: [],
        pagination: {
            current: 1,
            total: 0,
        },
    }),
    methods: {
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
        ideaPaginate() {
            let userToken = localStorage.getItem("userToken");
            this.status = "all";
            axios
                .get(`/idea?page=${this.pagination.current}`, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    let result = response.data;
                    this.ideas = result.data;
                    this.pagination.current = result.meta.current_page;
                    this.pagination.total = result.meta.last_page;
                })
                .catch((err) => {});
        },
        onPageChange() {
            if (this.status == "all") {
                this.search = "";
                this.category = "";
                this.otherFilters = "";
                this.ideaPaginate();
            }
            if (this.status) {
                this.search = "";
                this.category = "";
                this.otherFilters = "";
                return this.filteringIdeasBasedOnTheirStatuses(this.status);
            }
            if (this.category) {
                this.search = "";
                this.status = "";
                this.otherFilters = "";
                return this.filteringIdeasBasedOnTheirCategories();
            }
            if (this.otherFilters) {
                this.search = "";
                this.category = "";
                this.status = "";
                return this.filteringIdeasBasedOnOtherFilters();
            }
            if (this.search) {
                this.status = "";
                this.category = "";
                this.otherFilters = "";
                this.filteringIdeasBasedOnIdeaTitle();
            }
        },
        filteringIdeasBasedOnTheirStatuses(status) {
            let userToken = localStorage.getItem("userToken");
            this.status = status;
            axios
                .post(
                    `/filteringIdeasBasedOnTheirStatuses?page=${this.pagination.current}`,
                    {
                        status: this.status,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    let result = response.data;
                    this.ideas = result.data;
                    this.pagination.current = result.meta.current_page;
                    this.pagination.total = result.meta.last_page;
                })
                .catch((err) => {});
        },
        filteringIdeasBasedOnTheirCategories() {
            let userToken = localStorage.getItem("userToken");
            axios
                .post(
                    `/filteringIdeasBasedOnTheirCategories?page=${this.pagination.current}`,
                    {
                        category: this.category.name,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    let result = response.data;
                    this.ideas = result.data;
                    this.pagination.current = result.meta.current_page;
                    this.pagination.total = result.meta.last_page;
                })
                .catch((err) => {});
        },
        filteringIdeasBasedOnOtherFilters() {
            let userToken = localStorage.getItem("userToken");
            axios
                .post(
                    `/filteringIdeasBasedOnOtherFilters?page=${this.pagination.current}`,
                    {
                        otherFilters: this.otherFilters,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    let result = response.data;
                    this.ideas = result.data;
                    this.pagination.current = result.meta.current_page;
                    this.pagination.total = result.meta.last_page;
                })
                .catch((err) => {});
        },
        filteringIdeasBasedOnIdeaTitle() {
            let userToken = localStorage.getItem("userToken");
            axios
                .post(
                    `/filteringIdeasBasedOnIdeaTitle?page=${this.pagination.current}`,
                    {
                        search: this.search,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Authorization: userToken,
                        },
                    }
                )
                .then((response) => {
                    let result = response.data;
                    this.ideas = result.data;
                    this.pagination.current = result.meta.current_page;
                    this.pagination.total = result.meta.last_page;
                })
                .catch((err) => {});
        },
        ideaCountBasedOntheirStatus() {
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`/ideasCountBasedOntheirStatus`, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    let result = response.data;
                    this.countAllIdeas = result.AllIdeas;
                    this.consideringIdeas = result.consideringIdeas;
                    this.inProgressIdeas = result.inProgressIdeas;
                    this.implementedIdeas = result.implementedIdeas;
                    this.closedIdeas = result.closedIdeas;
                })
                .catch((err) => {});
        },
    },
};
</script>
filteringIdeasBasedOnIdeaTitle
