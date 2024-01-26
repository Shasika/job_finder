<template>
    <div>
        <div class="manage-jobs container py-5">
            <div class="title d-block mx-auto text-center mt-3 mb-5"
                 style="background: linear-gradient(to right, #3498db, #6c5b7b); color: #ffffff; padding: 20px; border: 2px solid #34495e; border-radius: 10px;">
                <h1 style="font-size: 0.5em; color: #f7f7f7; text-shadow: 2px 2px 4px #fb246a;">View Job</h1>
            </div>
            <div class="my-4">
                <form class="form col-md-12" role="form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Subject: </label>
                                <div>
                                    <span class="job-value-text">{{job.subject}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description: </label>
                                <span v-html="job.description"></span>
                            </div>
                            <div class="form-group">
                                <label>Requirements: </label>
                                <span v-html="job.requirements"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Education and Experience: </label>
                                <span v-html="job.education_and_experience"></span>
                            </div>
                            <div class="form-group">
                                <label>Location: </label>
                                <div>
                                    <span class="job-value-text">{{job.location}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Vacancy Count: </label>
                                <div>
                                    <span class="job-value-text">{{job.vacancy_count}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Salary: </label>
                                <div>
                                    <span class="job-value-text">{{ job.salary_currency + " " + job.salary }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Vacancy End Date: </label>
                                <div>
                                    <span class="job-value-text">{{job.vacancy_end_date}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Job Type: </label>
                                <div>
                                    <span class="job-value-text">  {{job.job_type}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <router-link :to="'/edit-job/' + job.job_id">
                            <button type="button" class="btn-block head-btn2 d-block w-50 mx-auto  py-3 my-4">{{"Edit"}}</button>
                        </router-link>
                    </div>
                </form>
            </div>

            <div class="my-4 py-5">
                <div class="title d-block mx-auto text-center mt-3 mb-5">
                    <h3>Applications</h3>
                </div>
                <div id="m_manage_register_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table class="table table-bordered table-checkable border border-light"
                           id="manage-applications-table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Candidate Name</th>
                            <th scope="col">Candidate Email</th>
                            <th scope="col">Resume</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="applications.length != 0" v-for="(application, index) in applications">
                            <td scope="row">{{ index + 1 }}</td>
                            <td>{{ application.candidate_name }}</td>
                            <td>{{ application.candidate_email }}</td>
                            <td class="text-center">
                                <a @click="downloadFile(application.id, application.candidate_name)">
                                    <i class="fa fa-download" aria-hidden="true"
                                       style="color: green; font-size: 22px"></i>
                                </a>
                            </td>
                        </tr>
                        <tr v-else>
                            <td>No records found</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "ViewJob",
    components: {},
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
            applications: []
        }
    },
    created() {
        this.jobId = this.$route.params.id ? this.$route.params.id : null;
    },
    mounted() {
        this.$openPreLoader();
        if (this.jobId) {
            this.jobDetails();
            this.getApplicatiosList();
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
        getApplicatiosList() {
            axios.get('/api/get-applications-by-job/' + this.jobId, {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.applications = response.data.data;
                }
            }).catch(error => {
                // Handle error response
                if (error.response && error.response.data && error.response.data.status) {
                    const errors = error.response.data;

                    this.$swal({
                        icon: 'error',
                        title: 'Login session is expired',
                        text: 'Please log in again.',
                        confirmButtonText: 'OK',
                        timer: 3000
                    }).then((result) => {
                        localStorage.removeItem("user");
                        localStorage.removeItem("token");
                        this.$router.push('/');
                        location.reload();
                    });
                }
            }).finally(res => {
                $(document).ready(function () {
                    $('#manage-applications-table').DataTable();
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
            this.job.job_type = jobData.job_type.job_type;
        },
        downloadFile(applicationId, candidateName) {
            let fileNameForDownload = candidateName + '.pdf';
            let contentType = '';
            axios.get("/api/download-resume/" + applicationId,
                {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    },
                    responseType: 'arraybuffer',
                    params: {
                        file_name: '',
                        content_type: contentType,
                        download_file_name: fileNameForDownload
                    }
                }).then(response => {
                    let blob = new Blob([response.data], {type: contentType})
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = this.decodeHtml(fileNameForDownload);
                    document.body.appendChild(link);
                    link.click();
            });
        },
        decodeHtml(html = '') {
            var txt = document.createElement("textarea");
            if (html && isNaN(parseFloat(html)) && isFinite(html) == false) {
                txt.innerHTML = html.split('').map((c) => {
                    return c === ' ' ? '&nbsp;' : c
                }).join('');
            } else {
                txt.innerHTML = html
            }
            return txt.value;
        },
    }
}
</script>

<style scoped>
.custom-text {
    color: red !important;
    text-align: left;
}
.job-value-text {
    color: #506172;
}

.form-group{
    margin-top: 4rem;
}
</style>
