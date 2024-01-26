<template>
    <div id="job-apply-modal" class="modal fade col-md-12 mx-auto" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply Job</h5>
                    <button type="button" class="close" @click="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>                            <small id="user_name" class="form-text text-muted custom-text" v-if="errorMessages.candidate_name">{{errorMessages.candidate_name[0]}}</small>

                        <div class="form-group">
                            <input v-model="models.user_name" id="candidateName" placeholder="Candidate Name" class="form-control form-control-sm" type="text"
                                   required="">
                        </div>
                        <div class="form-group">
                            <input v-model="models.user_email" id="candidateEmail" placeholder="Candidate Email" class="form-control form-control-sm" type="text"
                                   required="">
                            <small id="user_email" class="form-text text-muted custom-text" v-if="errorMessages.candidate_email">{{errorMessages.candidate_email[0]}}</small>
                        </div>
                        <div class="form-group custom-file">
                            <input type="file" @change="handleFileUpload" class="custom-file-input">
                            <label class="custom-file-label" for="inputGroupFile01">{{
                                    models.resume_file.name ? models.resume_file.name : 'Upload Resume.'
                                }}</label>
                            <small id="resume_file" class="form-text text-muted custom-text" v-if="errorMessages.resume_file">{{errorMessages.resume_file[0]}}</small>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="applyJob">Submit</button>
                    <button type="button" class="btn btn-secondary" @click="close">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "JobApplyModal",
    data() {
        return {
            models: {
                resume_file: {},
                user_name: '',
                user_email: ''
            },
            jobId: null,
            errorMessages: {
                resume_file: '',
                candidate_email: '',
                candidate_name: '',
            },
            user: []
        }
    },
    created() {
        this.jobId = this.$route.params.id;
        let user = localStorage.getItem('user');
        if (user) {
            this.user = JSON.parse(user);
            this.models.user_name = this.user[0].name;
            this.models.user_email = this.user[0].email;
        }
    },
    methods: {
        close() {
            this.$emit("close");
            this.resetInputs();
        },
        handleFileUpload(event) {
            this.models.resume_file = event.target.files[0];
        },
        applyJob() {
            const formData = new FormData();
            formData.append('resume_file', this.models.resume_file);
            formData.append('candidate_name', this.models.user_name);
            formData.append('candidate_email', this.models.user_email);
            formData.append('job_id', this.jobId);

            const headers = {
                'Content-Type': 'multipart/form-data',
                Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`
            };
            axios.post('/api/apply-job', formData, { headers }).then((response) => {
                if (response.data.data) {
                    this.resetInputs();

                    this.$swal({
                        icon: "success",
                        title: 'Successfully Applied',
                        showConfirmButton: true,
                        timer: 3000
                    }).then((result) => {
                        this.close();
                        this.$emit("getJobApplyStatusData");
                    })
                }
            }).catch(error => {
                // Handle error response
                if (error.response && error.response.data) {
                    const errors = JSON.parse(error.response.data);
                    if (errors.candidate_name) {
                        this.errorMessages.candidate_name = errors.candidate_name;
                    }
                    if (errors.candidate_email) {
                        this.errorMessages.candidate_email = errors.candidate_email;
                    }
                    if (errors.resume_file) {
                        this.errorMessages.resume_file = errors.resume_file;
                    }
                }
            }).finally(res => {
                // this.resetInputs();
            });
        },
        resetInputs() {
            this.models.resume_file = {};
            this.models.user_name = this.user[0].name;
            this.models.user_email = this.user[0].email;
            this.errorMessages.resume_file = '';
            this.errorMessages.candidate_name = '';
            this.errorMessages.candidate_email = '';
        },
    },
};
</script>

<style scoped>
.modal-body {
    text-align: center;
}

#job-apply-modal {
    margin-top: 10em;
}
.custom-text {
    color: red !important;
    text-align: left;
}
</style>
