<template>
    <div class="room-1">
        <div class="container__room">
            <div class="room__row">
                <div class="room__temperature-name">
                    <div class="room__temperature">
                        20&deg;c
                    </div>
                    <div class="room__name">
                        Название комнаты
                    </div>
                </div>
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
                        <img src="../../../public/icons/individual.png"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RoomBlock"
}
</script>
