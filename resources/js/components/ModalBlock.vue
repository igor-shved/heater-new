<template>
    <div v-if="isOpen" ref="currentModal" @click="closeModal" @keyup.esc="closeModal" class="modal__shadow">
        <div class="modal__container">
            <div class="modal__body" @click.stop>
                <slot name="header">
                    <div class="modal__header">
                        <a href="" @click.prevent="closeModal" class="modal__close">X</a>
                        <div class="modal__title">
                            <div v-if="itMainBlock">
                                Настройки
                            </div>
                            <div v-else>
                                Настройки комнаты № {{ room.id }}
                            </div>
                        </div>
                        <div class="modal__title">
                            {{ room.roomName }}
                        </div>
                        <div class="modal__title">
                            Режим: {{ selectModeText }}
                        </div>
                    </div>
                </slot>
                <slot name="content">
                    <div class="modal__content">
                        <div class="modal__mode_list">
                            <mode_block v-for="itemMode in arrayModes" ref="refMode"
                                        :itemMode="itemMode"
                                        :curMode="curMode"
                                        :key="'room'+room.id+String(itemMode.id)"
                                        @selectClick="selectClickMode"
                            />
                        </div>
                        <div class="modal__mode_setting">
                            <div class="modal__mode_block">
                                <a href="" @click.prevent="openModal"> <img src="/icons/settings-ex.png"/> </a>
                            </div>
                            <div class="modal__mode_block">
                                <a href="" @click.prevent="openModal"> <img src="/icons/t1.png"/> </a>
                            </div>
                            <div class="modal__mode_block">
                                <a href="" @click.prevent="openModal"> <img src="/icons/schedule-settings.png"/> </a>
                            </div>
                        </div>
                    </div>
                </slot>
                <slot name="footer">
                    <div class="modal__footer">
                        <button @click="saveSelectMode" class="modal__footer_button">OK</button>
                    </div>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
import mode_block from "./ModeBlock.vue"
export default {
    name: "modal_block",
    components: {mode_block},
    props: {
        arrayModes: {
            type: Array,
            default() {
                return [];
            }
        },
        room: {
            type: Object,
            default() {
                return {};
            }
        },
        curMode: {
            type: Number
        }
    },
    data() {
        return {
            isOpen: false,
            objectSettings: {},
            selectModeRoom: undefined,
        }
    },
    computed: {
        itMainBlock() {
            return this.room.id === 0 ? true : false;
        },
        selectModeText() {
            let filterItem =  this.arrayModes.filter(item =>
                item.id === this.room.currentMode
            );
            let textMode = '';
            if(filterItem.length === 1){
                textMode = filterItem[0]['textMode'];
            };
            return textMode;
        },
    },
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        escCloseModal(e) {
            if (this.isOpen && e.key === 'Escape') {
                this.closeModal();
            }
        },
        selectClickMode(idMode){
            this.selectModeRoom = this.room.currentMode !== idMode ? idMode : undefined;
            this.$refs.refMode.forEach(curRef => {
                if (curRef.id === idMode){
                    curRef.isSelect = true;
                } else {
                    curRef.isSelect = false;
                }
            });
        },
        saveSelectMode() {
            console.log(this.room.currentMode);
            console.log(this.selectModeRoom);
            if (this.room.currentMode !== this.selectModeRoom) {
                this.objectSettings.selectMode = this.selectModeRoom;
            }
            console.log(this.arraySettings);
            this.closeModal();
        },
        settingRoomClick(curRoom){
            this.$emit('settingClick', curRoom);
        }
    },
    mounted() {
        window.addEventListener('keydown', this.escCloseModal);
    },
    destroy() {
        window.removeEventListener('keydown', this.escCloseModal);
    }
}
</script>

<style scoped>

</style>
