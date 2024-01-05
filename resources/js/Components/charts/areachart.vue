<template lang="">
    <div class="row">
        <div class="col-md-12">
            <p class="fw-bold">{{ name }}</p>
            <canvas id="areaChart"></canvas>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
export default {
    name: "Chart Js",
    props: {
        yearlyData: {
            type: Object,
            required: true,
        }
    }, data() {
        return {
            name: "Monthly Sale History of " + new Date().getFullYear()
        }
    },
    mounted() {
        const ctx = document.getElementById('areaChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Sale',
                    data: this.yearlyData.sale,
                    backgroundColor: 'rgb(255, 192, 192)',
                    borderColor: 'rgb(255, 192, 192)',
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Sale History'
                        }
                    }
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
    }

}
</script>
<style lang="">
    
</style>