<template>
    <div>
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <button class="nav-link" :class="{ active: selectedTab === 'sale' }" @click="selectTab('sale')">
                    <i class="bx bx-user me-1"></i>Invoice
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" :class="{ active: selectedTab === 'billing' }" @click="selectTab('billing')">
                    <i class="bx bx-user me-1"></i>Billing
                </button>
            </li>
        </ul>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            selectedTab: 'sale' // Default selected tab is 'sale'
        };
    },
    methods: {
        selectTab(tab) {
            this.selectedTab = tab;
            this.$emit('tab-selected', tab); // Emit an event to the parent component
        }
    }
};
</script>
  
<style></style>
  