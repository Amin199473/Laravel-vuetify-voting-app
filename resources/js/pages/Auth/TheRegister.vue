<template>
    <v-sheet class="bg-deep-purple pa-12" rounded>
        <v-card class="mx-auto px-6 py-8" max-width="344">
            <v-form v-model="form" @submit.prevent="onSubmit">
                <v-text-field
                    v-model="name"
                    :readonly="loading"
                    :rules="[required]"
                    class="mb-2"
                    clearable
                    label="Name"
                >
                </v-text-field>

                <v-text-field
                    v-model="email"
                    :readonly="loading"
                    :rules="[required]"
                    class="mb-2"
                    clearable
                    label="Email"
                >
                </v-text-field>
                <v-text-field
                    v-model="password"
                    :readonly="loading"
                    :rules="[required]"
                    clearable
                    label="Password"
                    placeholder="Enter your password"
                >
                </v-text-field>

                <br />

                <v-btn
                    :disabled="!form"
                    :loading="loading"
                    block
                    color="success"
                    size="large"
                    type="submit"
                    variant="elevated"
                >
                    Register
                </v-btn>
            </v-form>
            <p class="font-weight-bold mt-3 text-center">
                already have account? please click
                <router-link to="/login" class="router-link">login</router-link>
            </p>
        </v-card>
    </v-sheet>
</template>

<script>
export default {
    data: () => ({
        form: false,
        name: null,
        email: null,
        password: null,
        loading: false,
    }),

    methods: {
        onSubmit() {
            if (!this.form) return;
            this.loading = true;
            setTimeout(() => (this.loading = false), 2000);
            try {
                this.$store.dispatch("Auth/userRegister", {
                    email: this.email,
                    name: this.name,
                    password: this.password,
                });
                return this.$router.push("/");
            } catch (error) {
                this.$router.push("/login");
                return false;
            }
        },
        required(v) {
            return !!v || "Field is required";
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
