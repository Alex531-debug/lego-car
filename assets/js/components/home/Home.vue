<template>
    <div>
        <car-list></car-list>
    </div>
</template>

<script>

    import CarList from "./../car/List.vue";

    export default {
        name: "Home",
        components: {
            CarList
        },
        data: function () {
            return {
                'test': 'test'
            }
        }
    }
</script>

<style scoped>

</style>