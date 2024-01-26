<template>
    <div>
        <div class="manage-jobs container py-5">
            <div class="title d-block mx-auto text-center mt-3 mb-5" style="background: linear-gradient(to right, #3498db, #6c5b7b); color: #ffffff; padding: 20px; border: 2px solid #34495e; border-radius: 10px;">
                <h1 style="font-size: 0.5em; color: #f7f7f7; text-shadow: 2px 2px 4px #fb246a;">{{pageTitle}}</h1>
            </div>

            <div class="my-4 col-md-8 mx-auto">
                <form class="form" role="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Subject</label>
                        <input v-model="job.subject" id="RegiNameInput" class="form-control form-control-sm" type="text"
                               required="">
                        <small id="subject" class="form-text text-muted custom-text" v-if="errors.subject">{{ errors.subject[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <vue-editor v-model="job.description" :editorToolbar="customToolbar"></vue-editor>
                        <small id="description" class="form-text text-muted custom-text" v-if="errors.description">{{ errors.description[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Requirements</label>
                        <vue-editor v-model="job.requirements" :editorToolbar="customToolbar"></vue-editor>
                        <small id="requirements" class="form-text text-muted custom-text" v-if="errors.requirements">{{ errors.requirements[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Education and Experience</label>
                        <vue-editor v-model="job.education_and_experience" :editorToolbar="customToolbar"></vue-editor>
                        <small id="education_and_experience" class="form-text text-muted custom-text" v-if="errors.education_and_experience">{{ errors.education_and_experience[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input v-model="job.location" id="RegiNameInput" class="form-control form-control-sm"
                               type="text" required="">
                        <small id="location" class="form-text text-muted custom-text" v-if="errors.location">{{ errors.location[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Vacancy Count</label>
                        <input v-model="job.vacancy_count" id="RegiNameInput" class="form-control form-control-sm"
                               type="text" required="">
                        <small id="vacancy_count" class="form-text text-muted custom-text" v-if="errors.vacancy_count">{{ errors.vacancy_count[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Salary Currency</label>
                        <input v-model="job.salary_currency" id="RegiNameInput" class="form-control form-control-sm"
                               type="text" required="">
                        <small id="salary_currency" class="form-text text-muted custom-text" v-if="errors.salary_currency">{{ errors.salary_currency[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <input v-model="job.salary" id="RegiNameInput" class="form-control form-control-sm" type="text"
                               required="">
                        <small id="salary" class="form-text text-muted custom-text" v-if="errors.salary">{{ errors.salary[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Vacancy End Date</label>
                        <input v-model="job.vacancy_end_date" id="RegiNameInput" class="form-control form-control-sm"
                               type="date" required="">
                        <small id="vacancy_end_date" class="form-text text-muted custom-text" v-if="errors.vacancy_end_date">{{ errors.vacancy_end_date[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Job Type</label>
                        <select v-model="job.job_type" class="form-control" >
                            <option value="" disabled selected>Select job type</option>
                            <option v-for="jobType in jobTypes" :value="jobType.id">{{ jobType.job_type }}</option>
                        </select>
                        <small id="job_type" class="form-text text-muted custom-text" v-if="errors.job_type">{{ errors.job_type[0] }}</small>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn-block head-btn2 d-block w-50 mx-auto  py-3 my-4" @click="createJob()">{{jobId ? 'Update Job' : 'Create Job'}}</button>
                    </div>
                </form>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
import {VueEditor} from "vue2-editor";
import Footer from "../Footer";

export default {
    name: "CreateJob",
    components: {
        Footer,
        VueEditor
    },
    data() {
        return {
            job: {
                job_id: null,
                subject: '',
                description: '',
                requirements: '',
                education_and_experience: '',
                location: '',
                vacancy_count: '',
                salary_currency: '',
                salary: '',
                vacancy_end_date: '',
                job_type: '',
            },
            jobId: null,
            customToolbar: [
                ["bold", "italic", "underline", "strike"],
                [{
                    align: ""
                }, {
                    align: "center"
                }, {
                    align: "right"
                }, {
                    align: "justify"
                }],
                [{list: "ordered"}, {list: "bullet"}],
                [{
                    indent: "-1"
                }, {
                    indent: "+1"
                }],
            ],
            jobTypes: [],
            errors: {},
            pageTitle: '',
        }
    },
    created() {
        this.jobId = this.$route.params.id ? this.$route.params.id : null;
        this.pageTitle = this.$route.params.id ? 'Edit Job' : 'Create Job';
    },
    mounted() {
        this.getJobTypes();
        if (this.jobId) {
            this.jobDetails();
        }
    },
    methods: {
        jobDetails() {
            axios.get('/api/get-job-details/' + this.jobId, {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.setJobData(response.data.data);
                }
            }).finally(res => {

            });
        },
        getJobTypes() {
            axios.get('/api/get-jobs-types', {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.jobTypes = response.data.data;
                }
            }).finally(res => {

            });
        },
        createJob() {
            axios.post('/api/job-create', this.job, {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    if (response.data.data.errors && response.data.data.errors.validations) {
                        this.errors = response.data.data.errors.validations;
                    } else {
                        let title = this.jobId ? 'Successfully updated' : 'Successfully created';
                        this.$swal({
                            icon: "success",
                            title: title,
                            showConfirmButton: true,
                            timer: 3000
                        }).then((result) => {
                            this.$router.push('/manage-jobs');
                        });
                    }
                }
            }).finally(res => {
                $(document).ready(function () {
                    $('#manage-job-table').DataTable();
                });
            });
        },
        setJobData(jobData) {
            this.job.job_id = jobData.id;
            this.job.subject = jobData.subject;
            this.job.description = jobData.description;
            this.job.requirements = jobData.requirements;
            this.job.education_and_experience = jobData.education_and_experience;
            this.job.location = jobData.location;
            this.job.vacancy_count = jobData.vacancy_count;
            this.job.salary_currency = jobData.salary_currency;
            this.job.salary = jobData.salary;
            this.job.vacancy_end_date = jobData.vacancy_end_date;
            this.job.job_type = jobData.job_type.id;
        },
    }
}
</script>

<style scoped>
.custom-text {
    color: red !important;
    text-align: left;
}

.manage-jobs .ql-container {
    height: 6em !important;
}
.manage-jobs  .ql-editor{
    min-height: 5em !important;
}

.manage-jobs .form-group input{
    padding: 1.5rem 2rem;
}

.manage-jobs select.form-control {
    height: 3rem !important;
}

.manage-jobs select.form-control option{
    border: none;
    opacity:0;
}



</style>
