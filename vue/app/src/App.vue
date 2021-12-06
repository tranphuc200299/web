<template>
    <router-view/>
</template>
<style>
</style>

<script>
    export default {
        name: 'App',
        created () {
            $("#loading").hide();

            document.title = "App Title";
        }
    }
</script>