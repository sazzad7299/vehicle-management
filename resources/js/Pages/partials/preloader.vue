<template>
    <div class="loading" id="loader" style="display: none" >
        <div class="spinner-border spinner-border-lg text-primary text-center" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="layouts" style="display: none"></div>
</template>
<script>

</script>
<style scoped>
#layouts {
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 9999;
    background-color: rgb(0 0 0 / 17%);
    pointer-events: none;
    transition: opacity 0.3s ease-in-out;
}
.loading {
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    transition: opacity 0.3s ease-in-out;
}

.spinner-border-lg {
    width: 5rem;
    height: 5rem;
    border-width: 0.4em;
}
</style>

