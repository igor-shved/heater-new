<template>
    <div class="modal__mode_block" :class="{'modal__bottom_line':isSelect}">
        <a href="" @click.prevent="selectMode(itemMode.id)"> <img :src="'/icons/' + itemMode.img"/> </a>
    </div>
</template>

<script>
export default {
    name: "mode_block",
    props: ['itemMode', 'curMode'],
    emits: ['selectClick'],
    data() {
        return {
            isSelect: this.itemMode.isSelect,
            selMode: undefined,
            id: this.itemMode.id,
        }
    },
    methods: {
        selectMode(idMode) {
            //console.log(idMode);
            this.selMode = idMode;
            this.isSelect = true;
            this.$emit('selectClick', idMode);
        }
    },
}
</script>

<style scoped>

</style>
