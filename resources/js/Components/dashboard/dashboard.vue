<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-2 mb-4 bg-light bg-gradient">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 mt-2 mb-2" v-for="data in summaryData" :key="data.id">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bxs-badge-dollar"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">{{ data.amount }} TK</h4>
                            </div>
                            <h5 class="card-title text-dark">{{ data.name }}</h5>
                            <p class="card-text"></p>
                        </div>
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
            summaryData: [],
        };
    },
    methods: {
        getSummary() {
            axios
                .get("report/summary")
                .then((response) => {
                    this.summaryData = response.data.result;
                    resolve(this.summaryData);
                })
                .catch((error) => {
                    reject(error);
                });
        },
    },
    mounted() {
        this.getSummary();
    },
};
</script>
