<template>
    <div class="room__row">
        <div class="room__clock-debug">
            <div class="room__clock-block">
                <div class="room__clock">
                    Часы
                </div>
                <div class="room__name-block">
                    Управление домом
                </div>
            </div>
            <div class="room__debug">
                <a href="#">
                    <img src="../../../public/icons/s-chat.png"/>
                </a>
            </div>
        </div>
        <div class="room__block-status">
            <div class="room__temperature-block">
                <div class="room__temperature-value">
                    20&deg;c
                </div>
                <div class="room__temperature-icon">
                    <a href="#">
                        <img src="../../../public/icons/t1.png"/>
                    </a>
                </div>
            </div>
            <div class="room__state">
                <img src="../../../public/icons/gaz.png"/>
            </div>
            <div class="room__settings">
                <a href="#">
                    <img src="{{ asset('icons/individual.png') }}"/>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MainBlock"
}
</script>
