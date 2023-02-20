<template>
    <div class="content">
        <template v-if="isLoadRoomsData">
            <room_block v-for="room in getRoomsData"
                        :room="room"
                        :key="room.id"
            />
        </template>
    </div>
</template>

<script>
import room_block from "./RoomBlock.vue";
//import axios from "axios";

export default {
    name: "heater_block",
    components: {
        room_block
    },
    computed: {
        getRoomsData() {
            return this.$store.state.roomsData;
        },
        isLoadInitData() {
            return this.$store.state.isLoadInitData;
        },
        isLoadRoomsData() {
            return this.$store.state.isLoadRoomsData;
        },
    },
    beforeCreate() {
        this.$store.dispatch('LOAD_ARRAY_INIT_DATA', '/api/get_array_init_data');
        this.$store.dispatch('LOAD_ROOMS_DATA', '/api/get_rooms_data');
    }
}
</script>

<style scoped>

</style>
