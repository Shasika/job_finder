<template>
    <div class="app">
        <header>
            <!-- Header Start -->
            <div class="header-area header-transparrent">
                <div class="headder-top header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-2">
                                <!-- Logo -->
                                <router-link :to="'/'">
                                    <div class="logo">
                                        <div><img src="/img/logo/logo.png" alt=""></div>
                                    </div>
                                </router-link>
                            </div>
                            <div class="col-lg-9 col-md-9">
                                <div class="menu-wrapper">
                                    <!-- Main-menu -->
                                    <div class="main-menu">
                                        <nav class="d-none d-lg-block">
                                            <ul id="navigation">
                                                <li>
                                                    <router-link to="/">
                                                        <div>Home</div>
                                                    </router-link>
                                                </li>
                                                <li v-if="isLogin && userRoleId != 3">
                                                    <router-link to="/user-dashboard">
                                                        <div>Admin</div>
                                                    </router-link>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- Header-btn -->
                                    <div v-if="!isLogin"  class="header-btn d-none f-right d-lg-block">
                                        <button @click="showRegisterModal" class="head-btn2 py-3 px-4">Register</button>
                                        <button @click="showLoginModal" class="head-btn2 py-3 px-4">Login</button>
                                    </div>
                                    <div v-else class="header-btn d-flex flex-row justify-content-between">
                                        <div @click="openProfileModel" class="profile-container mx-4 d-flex justify-content-center align-items-center">
                                            <span class="profile-letter">{{ user[0].name[0].toUpperCase()}}</span>
                                        </div>
                                        <button @click="logout" class="head-btn2 py-3 px-4 ml-2">Logout</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <Login @setUser="setLoginUser" @close="closeLoginModal"></Login>
        <Register @setUser="setLoginUser" @close="closeRegisterModal"></Register>
        <UserProfileModal ref="setUserData" @close="closeProfileModal" />
    </div>
</template>

<script>
import Login from "./components/Jobs/Login";
import Register from "./components/Jobs/Register";
import UserProfileModal from "./components/user/UserProfileModal";
export default {
    name: "Header",
    components: {UserProfileModal, Register, Login},
    data() {
        return {
            login: {
                email: '',
                password: '',
            },
            registration: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            currentRoute: '',
            user: '',
            isLog: 0,
            reset: {
                email: '',
                password: '',
            },
            loginError: '',
            isLogin: false,
            userRoleId: 3,


        }
    },
    created() {
        this.$nextTick(() => {
            let user = localStorage.getItem('user');
            if(user){
                this.isLogin =  true;
                this.user = JSON.parse(user);
                this.userRoleId = this.user[0].role_id;
            }
        });
    },
    methods: {
        log() {
            axios.post('/api/login', this.login
            ).then(response => {
                if (response.data.error) {
                    this.loginError = response.data.error;
                } else {
                    localStorage.setItem("user", JSON.stringify(response.data.user, response.data.token));
                    localStorage.setItem("token", JSON.stringify(response.data[0].token));
                    this.$router.push({path: "/user-dashboard"});
                    this.currentRoute = this.$router.currentRoute.name;
                }
                this.login.email = '';
                this.login.password = '';

            });

        },
        register() {
            axios.post('/api/register',
                this.registration
            ).then(response => {
                console.log(response.data);
            });
            location.reload();
            this.$router.push({path: "/"});

        },
        logout() {
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            this.$router.push({path: "/"});
            location.reload();
        },
        resetPassword() {
            axios.post('/api/reset-password',
                this.reset
            ).then(response => {
                console.log(response.data);
            });
            location.reload();
        },
        showLoginModal() {
            $("#login-modal").modal('show');
        },
        showRegisterModal() {
            $("#register-modal").modal('show');
        },
        closeLoginModal() {
            $("#login-modal").modal('hide');
        },
        closeRegisterModal() {
            $("#register-modal").modal('hide');
        },
        setLoginUser(value){
            if(value){
                this.isLogin = true;
                this.user = value;
                this.userRoleId = this.user[0].role_id;
            }
        },
        openProfileModel(){
            this.$refs.setUserData.setUserData();
        },
        closeProfileModal() {
            $("#user-profile-modal").modal('hide');
        }
    }
}
</script>

<style scoped>
   .profile-container .profile-letter {
       font-size: 3rem;
       font-weight: 700;
       line-height: 0;
       padding: 0;
       color:#fb246a;
    }
   .profile-container{
       cursor: pointer;
       background-color: transparent;
       padding: 0;
       min-height: 4rem;
       min-width: 4rem;
       border: 1px solid #fb246a;
       border-radius: 50%;
       position: relative;
   }

</style>
