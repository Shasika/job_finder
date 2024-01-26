<template>
    <div id="user-profile-modal" class="modal fade col-md-12 mx-auto" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">My profile</h5>
                    <button type="button" class="close" @click="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="profile-container mx-4 d-flex justify-content-center align-items-center">
                            <span class="profile-letter">{{ user.name[0].toUpperCase() }}</span>
                        </div>
                    </div>
                    <div class="user-data d-block mx-auto col-md-10 my-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div><span>Name</span></div>
                            </div>
                            <div class="col-md-4">
                                <div><span>{{ user.name }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div><span>Email</span></div>
                            </div>
                            <div class="col-md-4">
                                <div><span>{{ user.email }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="user.company_name"><span>Company Name</span></div>
                            </div>
                            <div class="col-md-4">
                                <div v-if="user.company_name"><span>{{ user.company_name }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="user.company_web"><span>Company Website</span></div>
                            </div>
                            <div class="col-md-4">
                                <div v-if="user.company_web"><span>{{ user.company_web }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="user.company_description"><span>Company Description</span></div>
                            </div>
                            <div class="col-md-4">
                                <div v-if="user.company_description"><span>{{ user.company_description }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="user.company_email"><span>Company Email</span></div>
                            </div>
                            <div class="col-md-4">
                                <div v-if="user.company_email"><span>{{ user.company_email }}</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="user.logo_path"><span>Company Logo</span></div>
                            </div>
                            <div class="col-md-4">
                                <div v-if="user.logo_path"><img class="logo-image" :src="user.logo_path ? user.logo_path : 'company_logos/not-found.png'" alt="Company Logo"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserProfileModal",
    data() {
        return {
            user: {}
        }

    },
    created() {

    },
    mounted() {

    },
    methods: {
        close() {
            this.$emit('close');
        },
        setUserData() {
            axios.get('/api/user',{
                headers: {
                    Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                }
            }).then(response => {
                if (response.data && response.data.user) {
                    this.user = response.data.user;
                }
            }).finally(res => {
                $("#user-profile-modal").modal('show');
            });
        }
    }
}
</script>

<style scoped>
.profile-container .profile-letter {
    font-size: 6rem;
    font-weight: 700;
    line-height: 0;
    padding: 0;
    color:#fb246a;
}
.profile-container{
    border: 1px solid #fb246a;
    min-height: 8rem;
    min-width: 8rem;
    border-radius: 50%;
}

.logo-image {
    max-width: 60px;
    max-height: 60px;
    width: auto;
    height: auto;
}
</style>
