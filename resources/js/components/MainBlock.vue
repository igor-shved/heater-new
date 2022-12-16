<template>
    <div class="all-room-0">
        <div class="container">
            <div class="all-room__row">
                <div class="all-room__clock-debug">
                    <div class="all-room__clock-block">
                        <div class="all-room__clock">
                            Часы
                        </div>
                        <div class="all-room__name-block">
                            Наименование комнаты
                        </div>
                    </div>
                    <div class="all-room__debug">
                        <a href="#">
                            <img src="../../../public/icons/s-chat.png"/>
                        </a>
                    </div>
                </div>
                <div class="all-room__temperature-block">
                    <div class="all-room__temperature-value">
                        20&deg;c
                    </div>
                    <div class="all-room__temperature-icon">
                        <a href="#">
                            <img src="../../../public/icons/t1.png"/>
                        </a>
                    </div>
                </div>
                <div class="all-room__state">
                    <img src="../../../public/icons/gaz.png"/>
                </div>
                <div class="all-room__settings">
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
    name: "MainBlock"
}
</script>
