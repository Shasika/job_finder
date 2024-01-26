<template>
    <div>
        <div class="manage-jobs container">
            <div class="title d-block mx-auto text-center mt-3 mb-5" style="background: linear-gradient(to right, #3498db, #6c5b7b); color: #ffffff; padding: 20px; border: 2px solid #34495e; border-radius: 10px;">
                <h1 style="font-size: 0.5em; color: #f7f7f7; text-shadow: 2px 2px 4px #fb246a;">Manage Jobs</h1>
            </div>
            <div class="add-jobs d-flex flex-row justify-content-end">
                <router-link to="create-job">
                    <button class="btn-block head-btn2 py-2 px-4">Create new job</button>
                </router-link>
            </div>
            <div class="my-4">
                <div id="m_manage_register_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table class="table table-bordered table-checkable border border-light" id="manage-job-table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Location</th>
                            <th scope="col">Vacancy Count</th>
                            <th scope="col">Vacancy End Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Applications Count</th>
                            <th scope="col">View</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="jobList.length != 0" v-for="(job, index) in jobList">
                            <td scope="row">{{ index + 1 }}</td>
                            <td>{{ job.subject }}</td>
                            <td>{{ job.location }}</td>
                            <td>{{ job.vacancy_count }}</td>
                            <td>{{ job.vacancy_end_date }}</td>
                            <td>{{ job.salary_currency + ' '+ job.salary}}</td>
                            <td>{{ job.applications.length }}</td>
                            <td class="text-center">
                                <router-link :to="'/view-job/' + job.id">
                                    <i class="fa fa-eye" aria-hidden="true" style="color: green; font-size: 22px"></i>
                                </router-link>
                            </td>
                            <td class="text-center">
                                <router-link :to="'/edit-job/' + job.id">
                                    <i class="fa fa-pencil" aria-hidden="true" style="color: green; font-size: 22px"></i>
                                </router-link>
                            </td>
                            <td class="text-center">
                                <a @click="deleteJob(job.id)">
                                    <i class="fa fa-trash" aria-hidden="true" style="color: red; font-size: 22px"></i>
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
    name: "ManageJobs",
    components: {

    },
    data() {
        return {
            jobList: [],
        }
    },
    mounted() {
        this.getJobList();
    },
    methods: {
        openCreateJobModal() {
            $("#job-modal").modal('show');
        },
        closeJobCreateModal() {
            $("#job-modal").modal('hide');
        },
        getJobList() {
            axios.get('/api/get-jobs-by-user', {
                    headers: {
                        Authorization: `Bearer ${JSON.parse(localStorage.getItem('token'))}`,
                    }
                }
            ).then(response => {
                if (response.data && response.data.data) {
                    this.jobList = response.data.data;
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
                    $('#manage-job-table').DataTable();
                });
            });
        },
        deleteJob(id) {
            this.$swal({
                title: 'Are you sure?',
                text: 'You can\'t revert your action',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'No, Keep it!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value){
                    axios.delete('/api/delete-job/'+ id
                    ).then(response => {
                        this.getJobList();
                    });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
