<template lang="">
    <div class="row">
        <div class="col-md-12">
            <p class="fw-bold">{{ name }}</p>
            <canvas id="pieChart"></canvas>
            <!-- <canvas v-else id="pieChart"></canvas> -->
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
export default {
    name: "Chart Js",
    props: {
        msg: String,
        summaryData: {
            type: Object,
            required: true,
        },

    },
    data() {
        return {
            name: "Account Total Summary",
            sale: 0,
            purchase: 0,
            cost: 0,
        }
    },
    mounted() {
        const labelsToFind = ['Sale', 'Purchase', 'Cost'];
        labelsToFind.forEach(label => {
            const data = this.summaryData.find(summary => summary.name === label);
            if (data) {
                this[label.toLowerCase()] = data.amount;
            }
        });
        const ctx = document.getElementById('pieChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Purchase',
                    'Cost',
                    'Sale'
                ],
                datasets: [{
                    label: 'Total',
                    data: [this.purchase, this.cost, this.sale],
                    backgroundColor: [
                        '#233446',
                        '#eb4d4b',
                        '#41A746'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    },
}
</script>
<style lang="">
    
</style>