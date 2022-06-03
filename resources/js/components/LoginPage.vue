<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" class="form-control" v-model="data.email" name="email"
                                        autocomplete="email" />
                                    <span class="text-danger">{{ emailError }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="data.password" class="form-control"
                                        name="password" required autocomplete="current-password" />
                                    <span class="text-danger">{{ passwordError }}</span>
                                    <span class="text-danger">{{ errors }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-spinner fa-spin" v-show="loading"></i>
                                        Login
                                    </button>
                                    <a class="btn btn-link" href="#">
                                        Forgot Your Password?
                                    </a>
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
            emailError: null,
            passwordError: null,
            errors: null,
        };
    },
    methods: {
        submit() {
            this.loading = true;
            this.errors = null;
            axios.post("/api/v1/users/login", this.data).then((response) => {
                if (response.data.status == 'error') {
                    this.errors = response.data.message;
                } else {
                    axios.post("/login", this.data);
                    let authToken = response.data.data.token;
                    sessionStorage.setItem('authToken', authToken);
                    window.location = '/home';
                }
                this.loading = false;
            }).catch((error) => {
                this.loading = false;
                this.emailError = error.response.data.errors.email == undefined ? null : error.response.data.errors.email[0];
                this.passwordError = error.response.data.errors.password == undefined ? null : error.response.data.errors.password[0];

            });
        },
    },
};
</script>

<style scoped>
</style>
