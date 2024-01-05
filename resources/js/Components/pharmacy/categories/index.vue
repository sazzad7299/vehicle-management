<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="fw-bold py-3 mb-4 "><span class="text-muted fw-light"></span>
            <router-link :to="{ name: 'customer.index' }">
                Customer List
            </router-link>
        </h4> -->
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <category-form v-if="hasPermission('category.create') || hasPermission('category.edit')" :category="selectedCategory"
                    @category-updated="updateCategoryInList"></category-form>
                <category-list @edit-category="editCategory"></category-list>
            </div>
        </div>
    </div>
</template>
<script>
import CategoryForm from './create.vue';
import CategoryList from './list.vue';

export default {
    components: {
        CategoryForm,
        CategoryList,
    },
    data() {
        return {
            selectedCategory: null,
        };
    },
    methods: {
        updateCategoryInList(updatedCategory) {
            // Find and update the category in the list
            const index = this.users.findIndex((user) => user.id === updatedCategory.id);
            if (index !== -1) {
                this.$set(this.users, index, updatedCategory);
            }
        },
        editCategory(category) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            this.selectedCategory = category;
        },
        // Other methods
    },
};
</script>
