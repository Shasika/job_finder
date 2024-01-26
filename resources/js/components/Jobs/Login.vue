<template>
    <div id="login-modal" class="modal fade col-md-12 mx-auto" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" @click="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" role="form">
                        <div class="form-group">
                            <input v-model="login.email" id="emailInput" placeholder="Email"
                                   class="form-control form-control-sm" type="email" required="">
                            <small id="c-name" class="form-text text-muted custom-text"
                                   v-if="loginError.email">{{ loginError.email[0] }}</small>
                        </div>
                        <div class="form-group">
                            <input v-model="login.password" id="passwordInput" placeholder="Password"
                                   class="form-control form-control-sm" type="password" required="">
                            <small id="c-name" class="form-text text-muted custom-text"
                                   v-if="loginError.password">{{ loginError.password[0] }}</small>
                        </div>
                        <div class="form-group" v-if="loginError.common">
                            <small id="c-name" class="form-text text-muted custom-text"
                                   v-if="loginError.common">{{ loginError.common }}</small>
                        </div>
                        <div class="form-group">
                            <button type="button" id="loginBtn" class="btn-block head-btn2 py-2" @click="log()"
                                    data-toggle="dropdown">Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="head-btn2 py-1 px-3" @click="close">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            login: {
                email: '',
                password: '',
            },
            reset: {
                email: '',
                password: '',
            },
            loginError: {
                common: '',
                email: '',
                password: '',
            },
        }
    },
    methods: {
        close() {
            this.$emit("close");
        },
        log() {
            axios.post('/api/login', this.login
            ).then(response => {
                if (response.data.error) {
                    this.loginError.common = response.data.error;
                    this.loginError.email = '';
                    this.loginError.password = '';
                } else {
                    localStorage.setItem("user", JSON.stringify(response.data.user, response.data.token));
                    localStorage.setItem("token", JSON.stringify(response.data[0].token));

                    if (response.data.user) {
                        this.$emit("setUser", response.data.user);
                    }

                    this.loginError.common = '';
                    this.loginError.email = '';
                    this.loginError.password = '';

                    this.$router.push({path: "/"});
                    this.currentRoute = this.$router.currentRoute.name;
                    this.close();
                }
                this.login.email = '';
                this.login.password = '';
            }).catch(error => {
                if (error.response && error.response.data) {
                    const errors = JSON.parse(error.response.data);
                    this.loginError.common = '';
                    this.loginError.email = errors.email ? errors.email : '';
                    this.loginError.password = errors.password ? errors.password : '';
                }
            });
        },
        logout() {
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            this.$router.push({path: "/"});
            location.reload();
        }
    },
}
</script>

<style scoped>
.modal-body {
    text-align: center;
}

#login-modal {
    margin-top: 0rem;
}

.custom-text {
    color: red !important;
    text-align: left;
}
</style>
