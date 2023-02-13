<template>
    <div class="content">
        <room_block v-for="room in get_rooms_data"
                    :room="room"
                    :key="room.id"
        />
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
        get_rooms_data() {
            return this.$store.state.rooms_data;
        }
    },
    mounted() {
        this.$store.dispatch('LOAD_ROOMS_DATA');

    }
}
</script>

<style scoped>

</style>
