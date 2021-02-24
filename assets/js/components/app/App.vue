<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "App",
        data: function () {
            return {
                'test': 'test1234'
            }
        }
    }
</script>

<style scoped>

</style>