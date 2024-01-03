<template>
    <AppLayout title="Vehicle List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vehicle List
            </h2>
        </template>
        <div class="container">
            <div class="row mt-2">
            <div class="card">
                <div class="card-body">
                    <div v-if="vehicles.length > 0">
                <!-- Display paginated table -->
                <table class="table text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-8 text-xs text-gray-500">
                              Vehicle ID
                            </th>
                            <th class="p-8 text-xs text-gray-500">
                                Model
                            </th>
                            <th class="p-8 text-xs text-gray-500">
                                Name
                            </th>

                            <th class="px-6 py-2 text-xs text-gray-500">
                               Reg. No
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-500">
                               License No
                            </th>

                            <th class="px-6 py-2 text-xs text-gray-500">
                               Exprire Date
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-500">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                            <tr class="whitespace-nowrap" v-for="vehicle in vehicles" :key="vehicle.id">
                                <td class="px-6 py-4 text-sm text-center text-gray-500">
                                    {{ vehicle.id }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ vehicle.model }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500"> {{ vehicle.name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500">
                                    {{ vehicle.reg_no }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500">
                                    {{ vehicle.license }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500"> {{ vehicle.expire_date }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">
                                            <!-- <a href="{{ route('admin.update',['id'=>$order->id])}}" class="opacity-100 mr-2 text-sm bg-blue-400 p-2 text-white"><i
                                                class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.delete',['id'=>$order->id]) }}" onclick="return confirm('Are You sure to delete this data?')"><i
                                                    class="fas fa-trash opacity-100 mr-2 text-sm text-white bg-red-400 p-2"></i></a> -->
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>

                <!-- Pagination links -->
                <div class="mt-4">
                    <inertia-link :href="pagination.prevPageUrl" :disabled="!pagination.prevPageUrl">
                        &laquo; Previous
                    </inertia-link>

                    <span class="mx-2">
                        Page {{ pagination.currentPage }} of {{ pagination.totalPages }}
                    </span>

                    <inertia-link :href="pagination.nextPageUrl" :disabled="!pagination.nextPageUrl">
                        Next &raquo;
                    </inertia-link>
                </div>
            </div>
            <div v-else>
                <p>No vehicles available.</p>
            </div>
                </div>
            </div>
        </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {InertiaLink} from "@inertiajs/inertia-vue3";

export default {
    components: { AppLayout,InertiaLink},
    props: {
        vehicles: Array, // Prop to receive vehicles from the controller
        pagination: Object, // Prop to receive pagination data from the controller
    },
    mounted(){
        console.log(this.vehicles);
    }
};
</script>

<style>
    a{
        text-decoration: none!important;
    }
</style>
