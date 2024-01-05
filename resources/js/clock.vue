<template>
   <span>{{ currentTime }}</span>
</template>
<script>
export default {
    data() {
        return {
            currentTime: '',
        };
    },
    methods: {
        updateTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const amPm = hours >= 12 ? 'PM' : 'AM';

            // Convert hours to 12-hour format
            if (hours > 12) {
                hours -= 12;
            } else if (hours === 0) {
                hours = 12;
            }

            this.currentTime = `${hours}:${minutes}:${seconds} ${amPm}`;
        },
    },
    mounted() {
        this.updateTime();
        setInterval(this.updateTime, 1000);
    }
}
</script>
<style scoped>
</style>