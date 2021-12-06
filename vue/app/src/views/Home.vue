<template>
    <div class="home">
        <Demo></Demo>
    </div>
</template>

<script>
    import Demo from '../components/Demo.vue';

    export default {
        name: 'Home',
        components: {
            'Demo': Demo
        },
        data: function () {
        },
        created() {
        }
    }
</script>
