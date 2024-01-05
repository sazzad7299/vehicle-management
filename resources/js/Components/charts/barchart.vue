<template lang="">
    <div class="row">
        <div class="col-md-12">
            <p class="fw-bold">{{ name }}</p>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
import randomColor from 'randomcolor';
export default {
    name: "Chart Js",
    props: {
        balance:{
            type:Object,
            required:true
        }
    }, data() {
        return {
            name: "Current Account Balance"
        }
    },
    mounted() {
        const ctx = document.getElementById('myChart');
        // const labels = this.balance.map(item => item.name);
        // const data = this.balance.map(item => item.current_balance);
        const datasets = this.balance.map(item => {
            const color = randomColor();
                return {
                    label: item.name,
                    data: [item.current_balance],
                    backgroundColor: color + '80', // Adding alpha for transparency
                    borderColor: color,
                    borderWidth: 1,
                };
                });

        // console.log(data)
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Current Balance'],
                datasets: datasets,
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    },
}
</script>
<style lang="">
    
</style>