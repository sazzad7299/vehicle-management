<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pharmacy  /</span>Pharmacy List</h4>
        <div class="card">
            <div class="card-datatable table-responsive">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row ms-2 me-3">
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                            <div class="dataTables_length">
                                <label>
                                    <select v-model.number="perPage" class="form-select">
                                        <option :value="item" v-for="(item,index) in items" :key="index">{{
                                                item
                                            }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3" v-if="hasPermission('pharmacy.create')">
                                <div class="dt-buttons btn-group flex-wrap">
                                    <router-link :to="{ name: 'pharmacy.create'}">
                                        <button class="btn btn-secondary btn-primary" type="button">
                                            <span>
                                              <i class="bx bx-plus me-md-1"></i>
                                              <span class="d-md-inline-block d-none">Create Pharmacy</span>
                                            </span>
                                        </button>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-2">
                            <div class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control" placeholder="Search" v-model="search"
                                           aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </div>
                    </div>
                    <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="pharmacies?.data?.length === 0">
                            <td colspan="9" class="text-center">No data available</td>
                        </tr>
                        <tr v-else :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(pharmacy, index) in pharmacies.data">
                            <td class="fw-semibold">
                                {{ pharmacies.from + index }}
                            </td>
                            <td class="fw-semibold">
                                {{ pharmacy.company_name }}
                            </td>
                            <td class="fw-semibold">
                                {{ pharmacy.owner?.name }}
                            </td>
                            <td class="text-left" v-if="hasPermission('pharmacy.edit')">
                                <div class="demo-inline-spacing">
                                    <router-link :to="{ name: 'pharmacy.edit',params:{ id:pharmacy.id }}">
                                        <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                            <i class="bx bx-edit-alt mx-1"></i>
                                        </button>
                                    </router-link>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ pharmacies.from }}
                                to {{ pharmacies.to }} of {{ pharmacies.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="pharmacies" :limit="10" :align="'right'"
                                        @pagination-change-page="getPaginatedPharmacy($event)"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    name: 'Pharmacy Index',
    data() {
        return {
            pharmacies: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getPharmacy({page: 1, perPage})
        },
        search: _.debounce(function (search) {
            this.getPharmacy({page: 1, search})
        }, 500),
    },
    methods: {
        getPaginatedPharmacy(page) {
            this.getPharmacy({page: page});
            this.scrollToTop();
        },
        getPharmacy({page = 1, perPage = this.perPage, search = this.search}) {
            this.loader(true);
            axios.get('/pharmacy', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.pharmacies = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error);
                })
        }
    },
    mounted() {
        this.getPharmacy({page: 1});
    }

}
</script>

<style scoped>

</style>
