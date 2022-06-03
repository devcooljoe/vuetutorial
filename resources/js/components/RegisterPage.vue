<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" v-model="data.name"
                                        autocomplete="name">
                                    <span class="text-danger">{{ nameError }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                                <div class="col-md-6">
                                    <input id="email" v-model="data.email" class="form-control"
                                        name="email" autocomplete="email">
                                    <span class="text-danger">{{ emailError }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password" v-model="data.password" type="password" class="form-control"
                                        name="password" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" v-model="data.password_confirmation" type="password"
                                        class="form-control" name="password_confirmation" autocomplete="new-password">
                                    <span class="text-danger">{{ passwordError }}</span>
                                    <span class="text-danger">{{ errors }}</span>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" v-show="loading"></i> Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {},
            loading: false,
            nameError: null,
            emailError: null,
            passwordError: null,
            errors: null,
        };
    },
    methods: {
        submit() {
            this.loading = true;
            this.errors = null;
            axios.post("/api/v1/users/register", this.data).then((response) => {
                if (response.data.status == 'error') {
                    this.errors = response.data.message;
                } else {
                    console.log(response.data);
                    // window.location = '/home';
                }
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
                this.nameError = error.response.data.errors.name == undefined ? null : error.response.data.errors.name[0];
                this.emailError = error.response.data.errors.email == undefined ? null : error.response.data.errors.email[0];
                this.passwordError = error.response.data.errors.password == undefined ? null : error.response.data.errors.password[0];
            });
        },
    },

}
</script>
