<template>
    <div class="modal__mode_list">
        <mode_block v-for="itemMode in arrayModes"
                    :itemMode="itemMode"
                    :class="{'modal__bottom_line':itemMode.isSelect}"
                    :key="'mode'+room.id+String(itemMode.id)"
        />
    </div>

</template>

<script>
import mode_block from "./ModeBlock.vue";
import {mapState, mapGetters, mapActions} from "vuex";
export default {
    name: "modal_list",
    components: {mode_block},
    props: {
        roomProps: {
            type: Object,
            default() {
                return {};
            }
        },
    },
    data() {
        return {
            room: this.roomProps,
            isOpen: false,
            arrayModes: [],
            objectSettings: {},
        }
    },
    created() {
        this.arrayModes = this.$getArrayModesFromRoom(this.roomProps.id);
        this.$eventBus.$on('select_mode_click', this.selectModeClick);
    },
    beforeDestroy() {
        this.$eventBus.$off('select_mode_click', this.selectModeClick);
    },
    computed: {},
    methods: {
        selectModeClick(idMode) {
            let selectMode = this.roomProps.currentMode !== idMode ? idMode : undefined;
            this.$eventBus.$emit('select_mode_set', selectMode);

            this.arrayModes.forEach(item => {
                if (item.id === idMode) {
                    item.isSelect = true;
                } else {
                    item.isSelect = false;
                }
            });
        },
    },
}
</script>

<style scoped>

</style>
