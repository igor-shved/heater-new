<template>
    <header class="header">
        <nav>
            <ul class="menu__list">
                <li v-for="(link_item, index) in menu_link"
                    :key="index"
                >
                    <a :href="link_item.link">{{ link_item.title }}</a>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    name: "menu_block",
    data() {
        return {
            menu_link: [
                {
                    title: "Управление домом",
                    link: "/"
                },
                {
                    title: "Debug heater2",
                    link: "/debug"
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>
