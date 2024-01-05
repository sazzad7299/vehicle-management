<template lang="">
    <div class="row">
        <div class="col-md-12">
            <p class="fw-bold">{{ name }}</p>
            <canvas id="DoubleChart"></canvas>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
export default {
    name: "Chart Js",
    props: {
        yearlyData:{
            type:Object,
            required:true,
        }

    }, data() {
        return {
            name: "Monthly Purchase, Sale & Cost History of " + new Date().getFullYear(),
        }
    },
    mounted() {
        const ctx = document.getElementById('DoubleChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February','March', 'April','May','June','July','August','September','October','November','December'],
                datasets: [{
                    label: 'Sale',
                    data: this.yearlyData.sale,
                    fill: false,
                    backgroundColor:'#41A746',
                    borderColor: '#41A746',
                    tension: 0.1
                },
                {
                    label: 'Purchase',
                    data: this.yearlyData.purchase,
                    fill: false,
                    backgroundColor:'#233446',
                    borderColor: '#233400',
                    tension: 0.1
                },
                {
                    label: 'Cost',
                    data: this.yearlyData.cost,
                    fill: false,
                    backgroundColor:'#eb4d4b',
                    borderColor: '#c0392b',
                    tension: 0.1,
                },]
            },
            options: {
                scales: {
                    // y: {
                    //     beginAtZero: true,
                    //     title: {
                    //         display: true,
                    //         text: 'Sale History'
                    //     }
                    // },x: {
                    //     beginAtZero: true,
                    //     title: {
                    //         display: true,
                    //         text: 'Sale History'
                    //     }
                    // }
                },
                layout: {
                    // padding: { 
                    //     left: 20, 
                    //     right: 20, 
                    //     top: 20, 
                    //     bottom: 20 
                    // } 
                }
            }
        });
    },
}
</script>
<style lang="">
    
</style>