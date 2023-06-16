<template>
    <div>
        <v-dialog v-model="dialog" scrollable width="400" height="600">
            <template v-slot:activator="{ props }">
                <v-btn
                    v-bind="props"
                    height="56"
                    width="140"
                    size="x-large"
                    append-icon="mdi-arrow-down"
                >
                    Status
                    <template v-slot:append>
                        <v-icon color="warning"></v-icon>
                    </template>
                </v-btn>
            </template>
            <v-card>
                <v-card-title>Select Status</v-card-title>
                <v-divider></v-divider>
                <v-card-text style="height: 300px">
                    <v-radio-group
                        :model-value="name"
                        :value="status"
                        @input="(event) => (status = event.target.value)"
                        column
                    >
                        <v-radio
                            v-for="status in statuses"
                            :key="status.id"
                            :color="status.color"
                            :label="status.name"
                            :value="status.name"
                        ></v-radio>
                    </v-radio-group>
                    <v-textarea
                        label="Add an Update Comment(Optional)"
                        variant="solo-filled"
                    ></v-textarea>
                    <v-checkbox
                        v-model="notifyAllVoters"
                        label="Notify All voters"
                        color="info"
                    ></v-checkbox>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="error" @click="dialog = false"> Close </v-btn>
                    <v-btn color="success" @click="changeStatus()">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import alerts from "../../../alerts/index.js";
export default {
    created() {
        this.getStatuses();
    },
    props: {
        name: { required: true },
    },
    data: () => {
        return {
            statuses: [],
            status: "",
            dialog: false,
            notifyAllVoters: false,
        };
    },
    methods: {
        getStatuses() {
            let userToken = localStorage.getItem("userToken");
            axios
                .get(`status`, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: userToken,
                    },
                })
                .then((response) => {
                    this.statuses = response.data.data;
                })
                .catch((error) => {});
        },
        changeStatus() {
            let userToken = localStorage.getItem("userToken");
            let slug = this.$route.params.slug;
            axios
                .post(
                    "idea/updateStatus",
                    {
                        status: this.status,
                        slug: slug,
                        notifyAllVoters: this.notifyAllVoters,
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
                .catch((error) => {
                    alerts.errorAlert("something went wrong");
                });
        },
    },
};
</script>
