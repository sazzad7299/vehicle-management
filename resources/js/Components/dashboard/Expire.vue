<!-- Expire.vue -->
<template >
    <div class="col-lg-6 col-md-6 col-sm-12 mt-4" v-if="expireData && expireData.data && expireData.data.length > 0">
        <div class="card h-100">
            <div class="card-header">
                <h4>Expire Medicine</h4>
            </div>
            <div class="card-datatable table-responsive">
                <table class="invoice-list-table table border-top dataTable no-footer dtr-column">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Barcode</th>
                            <th>Expire At</th>
                            <th>P.P</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                            <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(expire, index) in expireData.data">
                                <td>{{ expireData.from + index }}</td>
                                <td>{{ expire.medicine.barcode }}</td>
                                <td>{{ expire.expire_date }}</td>
                                <td>{{ expire.pp }}</td>
                                <td><router-link :to="{ name: 'purchase.view',params:{ id:expire.purchase_id }}">
                                        <button type="button" class="btn btn-sm btn-primary ">
                                            <i class='bx bxs-bullseye'></i>
                                        </button>
                                    </router-link></td>
                            </tr>
                       
                        </tbody>
                    </table>
                    
                    <div class="row mx-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="fw-semibold" role="status" aria-live="polite">
                                Showing {{ expireData.from }}
                                to {{ expireData.to }} of {{ expireData.total }} entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <pagination :data="expireData" :limit="10" :align="'right'"
                                        @pagination-change-page="fetchStockoutData($event)"/>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>              
</template>
  
<script>
export default {
    props:{
        expireData: {
            type: Object,
            required: true,
        },
    }
};
</script>
<style scoped>

</style>
  