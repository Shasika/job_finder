<template>
    <div id="register-modal" class="modal fade col-md-12 mx-auto" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register here</h5>
                    <button type="button" class="close" @click="close">
                        <span>&times;</span>
                    </button>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item flex-grow-1 d-flex" role="presentation">
                        <button class="nav-link active flex-grow-1" id="user-tab" data-toggle="tab"
                                data-target="#employer" type="button" role="tab" aria-controls="employer"
                                aria-selected="true" @click="showTab('#employer')">Employer
                        </button>
                    </li>
                    <li class="nav-item flex-grow-1 d-flex" role="presentation">
                        <button class="nav-link flex-grow-1" id="admin-tab" data-toggle="tab" data-target="#candidate"
                                type="button" role="tab" aria-controls="candidate" aria-selected="false"
                                @click="showTab('#candidate')">Candidate
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="employer" role="tabpanel" aria-labelledby="user-tab">
                        <div class="modal-body">
                            <form class="form" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input v-model="registration.e_name" id="RegiNameInput" placeholder="Name"
                                           class="form-control form-control-sm" type="text" required="">
                                    <small id="name" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.name">{{ employerErrorMessages.name[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.e_email" id="RegiEmailInput" placeholder="Email"
                                           class="form-control form-control-sm" type="email" required="">
                                    <small id="email" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.email">{{ employerErrorMessages.email[0] }}</small>

                                </div>
                                <div class="form-group">
                                    <input v-model="registration.company_name" id="RegiComNameInput"
                                           placeholder="Company Name" class="form-control form-control-sm" type="text"
                                           required="">
                                    <small id="company_name" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.company_name">{{ employerErrorMessages.company_name[0] }}</small>

                                </div>
                                <div class="form-group">
                                    <input v-model="registration.company_web" id="RegiComWebInput"
                                           placeholder="Company Website" class="form-control form-control-sm"
                                           type="text" required="">
                                    <small id="company_web" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.company_web">{{ employerErrorMessages.company_web[0] }}</small>

                                </div>
                                <div class="form-group">
                                    <input v-model="registration.company_email" id="RegiComEmailInput"
                                           placeholder="Company Email" class="form-control form-control-sm" type="text"
                                           required="">
                                    <small id="company_email" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.company_email">{{ employerErrorMessages.company_email[0] }}</small>

                                </div>
                                <div class="form-group">
                                    <input v-model="registration.company_description" id="RegiComDescriptionInput"
                                           placeholder="Company Description" class="form-control form-control-sm"
                                           type="text" required="">
                                    <small id="company_description" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.company_description">{{ employerErrorMessages.company_description[0] }}</small>

                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="file" id="formFile" @change="handleFileChange">
                                    <small id="company_logo" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.company_logo">{{ employerErrorMessages.company_logo[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.e_password" id="RegiPassowrdInput" placeholder="Password"
                                           class="form-control form-control-sm" type="password" required="">
                                    <small id="password" class="form-text text-muted custom-text"
                                           v-if="employerErrorMessages.password">{{ employerErrorMessages.password[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.e_password_confirmation" id="RegiConfirmPasswordInput"
                                           placeholder="Confirm Password" class="form-control form-control-sm"
                                           type="password" required="">
                                    <small class="form-text small pwd-confirmation ">* Must similar with above
                                        password</small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn-block head-btn2 py-2" @click="register('user')"
                                            data-toggle="dropdown">Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="candidate" role="tabpanel" aria-labelledby="admin-tab">
                        <div class="modal-body">
                            <form class="form" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input v-model="registration.c_name" id="RegiNameInput" placeholder="Name"
                                           class="form-control form-control-sm" type="text" required="">
                                    <small id="c-name" class="form-text text-muted custom-text"
                                           v-if="candidateErrorMessages.name">{{ candidateErrorMessages.password[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.c_email" id="RegiEmailInput" placeholder="Email"
                                           class="form-control form-control-sm" type="email" required="">
                                    <small id="c-email" class="form-text text-muted custom-text"
                                           v-if="candidateErrorMessages.email">{{ candidateErrorMessages.email[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.c_password" id="RegiPassowrdInput" placeholder="Password"
                                           class="form-control form-control-sm" type="password" required="">
                                    <small id="c-password" class="form-text text-muted custom-text"
                                           v-if="candidateErrorMessages.password">{{ candidateErrorMessages.password[0] }}</small>
                                </div>
                                <div class="form-group">
                                    <input v-model="registration.c_password_confirmation" id="RegiConfirmPasswordInput"
                                           placeholder="Confirm Password" class="form-control form-control-sm"
                                           type="password" required="">
                                    <small class="form-text small pwd-confirmation ">* Must similar with above
                                        password</small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn-block head-btn2 py-2" @click="register('admin')"
                                            data-toggle="dropdown">Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="head-btn2 btn-close py-1 px-3" @click="close">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            registration: {
                e_name: '',
                c_name: '',
                e_email: '',
                c_email: '',
                e_password: '',
                c_password: '',
                e_password_confirmation: '',
                c_password_confirmation: '',
                company_name: '',
                company_web: '',
                company_email: '',
                company_description: '',
            },
            currentRoute: '',
            user: '',
            isLog: 0,
            loginError: '',
            company_logo: null,
            selectedTab: 'EMPLOYER',
            employerErrorMessages: {
                name: '',
                email: '',
                password: '',
                company_logo: '',
                company_email: '',
                company_name: '',
                company_description: '',
                company_web: '',
            },
            candidateErrorMessages: {
                name: '',
                email: '',
                password: '',
            },
            userRoleId: null,
        }
    },
    methods: {
        close() {
            this.$emit("close");
        },
        register() {
            const formData = new FormData();
            if (this.selectedTab === 'EMPLOYER') {
                formData.append('company_logo', this.company_logo);
                formData.append('company_name', this.registration.company_name);
                formData.append('company_web', this.registration.company_web);
                formData.append('company_email', this.registration.company_email);
                formData.append('company_description', this.registration.company_description);
                formData.append('name', this.registration.e_name);
                formData.append('email', this.registration.e_email);
                formData.append('password', this.registration.e_password);
                formData.append('password_confirmation', this.registration.e_password_confirmation);
            } else {
                formData.append('name', this.registration.c_name);
                formData.append('email', this.registration.c_email);
                formData.append('password', this.registration.c_password);
                formData.append('password_confirmation', this.registration.c_password_confirmation);
            }
            formData.append('selectedTab', this.selectedTab);
            const headers = {'Content-Type': 'multipart/form-data'};
            axios.post('/api/register', formData, {headers}).then((response) => {
                if (response.data.error) {
                    this.loginError = response.data.error;
                } else {
                    localStorage.setItem("user", JSON.stringify([response.data.user], response.data.token));
                    localStorage.setItem("token", JSON.stringify(response.data.token));

                    if (response.data.user) {
                        this.$emit("setUser", [response.data.user]);
                        this.userRoleId = response.data.user.role_id;
                    }
                    this.resetInputs();
                    if (this.userRoleId === 3) {
                        this.$router.push({path: "/"});
                        this.currentRoute = this.$router.currentRoute.name;
                    } else {
                        this.$router.push({path: "/user-dashboard"});
                        this.currentRoute = this.$router.currentRoute.name;
                    }
                    this.close();
                }
            }).catch(error => {
                if (error.response && error.response.data) {
                    const errors = JSON.parse(error.response.data);
                    if (this.selectedTab === 'EMPLOYER') {
                        this.employerErrorMessages.name = errors.name ? errors.name : '';
                        this.employerErrorMessages.email = errors.email ? errors.email : '';
                        this.employerErrorMessages.password = errors.password ? errors.password : '';
                        this.employerErrorMessages.company_description = errors.company_description ? errors.company_description : '';
                        this.employerErrorMessages.company_name = errors.company_name ? errors.company_name : '';
                        this.employerErrorMessages.company_email = errors.company_email ? errors.company_email : '';
                        this.employerErrorMessages.company_web = errors.company_web ? errors.company_web : '';
                        this.employerErrorMessages.company_logo = errors.company_logo ? errors.company_logo : '';
                    } else {
                        this.candidateErrorMessages.name = errors.name ? errors.name : '';
                        this.candidateErrorMessages.email = errors.email ? errors.email : '';
                        this.candidateErrorMessages.password = errors.password ? errors.password : '';
                    }
                }
            }).finally(res => {

            });

        },
        handleFileChange(event) {
            this.company_logo = event.target.files[0];
        },

        resetInputs() {
            this.registration.name = '';
            this.registration.email = '';
            this.registration.password = '';
            this.registration.password_confirmation = '';
            this.registration.company_name = '';
            this.registration.company_web = '';
            this.registration.company_email = '';
            this.registration.company_description = '';
            this.company_logo = null;
        },

        showTab(id) {
            this.selectedTab = id === '#employer' ? 'EMPLOYER' : 'CANDIDATE';
            $(id).tab('show');
        }
    },
}
</script>

<style scoped>
.modal-body {
    text-align: center;
}

#register-modal {
    margin-top: 0rem;
}

#register-modal .nav-tabs .nav-link {
    background-color: #fff;
    color: black;
    border: 1px solid white;
}

#register-modal .nav-tabs .nav-link.active {
    background-color: #fb246a;
    color: white;
    border: 1px solid #fb246a !important;
}

.custom-text {
    color: red !important;
    text-align: left;
}

.pwd-confirmation {
    color: #ffc107 !important;
    text-align: left !important;
}
</style>
