<template>
    <div class="room">
        <modal_block ref="modalSelectMode" :room="room" :arrayModes="arrayModes" :key="'modalSelect'+String(room.id)"
                     :curMode="room.currentMode"/>
        <modal_block ref="modalSettingRoom" :room="room" :arrayModes="arrayModes" :key="'modalSetting'+String(room.id)"
                     :curMode="room.currentMode"/>
        <modal_block ref="modalSheduler" :room="room" :arrayModes="arrayModes" :key="'modalSheduler'+String(room.id)"
                     :curMode="room.currentMode"/>
        <div v-if="itMainBlock" class="room__clock_debug">
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
                <img v-if="onRelay" src="/icons/h.png"/>
            </div>
            <div class="room__settings">
                <a href="" @click.prevent="openModal">
                    <img :src="imgSettings"/>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import modal_block from "./ModalBlock.vue"

export default {
    name: "room_block",
    components: {
        modal_block
    },
    emits:['settingRoomClick'],
    props: {
        room: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    data() {
        return {
            arrayModes: []
        }
    },
    computed: {
        itMainBlock() {
            return this.room.id === 0 ? true : false;
        },
        imgSettings() {
            return '/icons/' + this.arrayModes.filter(item => {
                return item.id === this.room.currentMode;
            })[0]['img'];
        },
        onRelay() {
            return this.room.currentStatusRelay === 1 ? true : false;
        }
    },
    methods: {
        openModal() {
            this.$refs.modalSelectMode.isOpen = true;
        },
        closeModal() {
            this.$refs.modalSelectMode.isOpen = false;
        },
        settingRoomClick(curRoom){
          console.log('setting click room');
        },
    },
    beforeMount() {
        let arrModes = [];
        if (this.room.id === 0) {
            arrModes = this.$store.state.arrayInitData.homeModes;
        } else {
            arrModes = this.$store.state.arrayInitData.roomsModes;
        }
        arrModes.forEach(item => {
            let isSelect = item.id === this.room.currentMode ? true : false;
            let itemNew = {
                id: item.id,
                img: item.img,
                textMode: item.textMode,
                isSelect: isSelect
            };
            this.arrayModes.push(itemNew);
        })
    }
}
</script>
