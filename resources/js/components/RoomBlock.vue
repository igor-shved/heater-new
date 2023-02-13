<template>
    <div class="room">
        <modal_window ref="modal" :room="room" :key="room.id"></modal_window>
        <div v-if="it_main_block" class="room__clock_debug">
            <div class="room__clock_block">
                <div class="room__clock">
                    Часы
                </div>
                <div class="room__name_block">
                    {{ room.roomName }}
                </div>
            </div>
            <div class="room__debug">
                <a href="#">
                    <img src="/icons/s-chat.png"/>
                </a>
            </div>
        </div>

        <div v-else class="room__temperature_name">
            <div class="room__temperature">
                <span>{{ room.rightNowTemp }}&deg;c</span>
                <span>№ комнаты: {{ room.id }}</span>
            </div>
            <div class="room__name">
                {{ room.roomName }}
            </div>
        </div>

        <div class="room__block_status">
            <div class="room__temperature_block">
                <div class="room__temperature_icon">
                    <a href="" @click.prevent="debug">
                        <img src="/icons/t1.png"/>
                    </a>
                </div>
                <div class="room__temperature_value">
                    {{ room.standByTemp }}&deg;c
                </div>
            </div>
            <div class="room__state">
                <img src="/icons/gaz.png"/>
            </div>
            <div class="room__settings">
                <a href="" @click.prevent="openModal">
                    <img src="/icons/individual.png"/>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import ModalWindow from "./ModalWindow.vue"

export default {
    name: "room_block",
    components: {
        ModalWindow
    },
    props: {
        room: {
            type: Object,
            default() {
                return {};
            }
        }
        },
    data() {
        return {}
    },
    computed: {
        it_main_block() {
            return this.room.id === 0 ? true : false;
        }
    },
    methods: {
        /* async openModal() {
            const modalResult = await this.$refs.actionModal.open();
            console.log('сработало');
            if (modalResult) {
                console.log(modalResult);
            }
        }*/
        getKey() {
            console.log(this.$props.key);
        },
        openModal() {
            this.$refs.modal.isOpen = true;
        },
        closeModal() {
            this.$refs.modal.isOpen = false;
        },
        debug() {
            console.log('key= ' + this.$props.key);
        }
    }
}
</script>
