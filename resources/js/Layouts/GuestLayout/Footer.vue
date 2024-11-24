<script setup>
import {Link} from "@inertiajs/vue3";
import Svg from "@/Components/Common/Svg.vue";

</script>

<template>
    <footer class="footer border-t border-white/20">
        <div class="container py-3">
            <div class="flex max-lg:text-center max-lg:flex-col items-center justify-between">
                <p class="footerPolice">© 2022 - {{ new Date().getFullYear() }} RU:STREAM. Все права защищены.</p>
                <nav class="text-sm flex max-lg:flex-col lg:space-x-4">
                    <Link class="link" :href="route('terms.show')">
                        Условия предоставления услуг
                    </Link>
                    <Link class="link" :href="route('policy.show')">
                        Обработка персональных данных
                    </Link>
                </nav>
                <div class="flex items-center space-x-2">
                    <a href="https://vk.cc/cfOIIa" title="VK" target="_blank">
                        <Svg class="shrink-0 size-6" icon="vk-page"/>
                    </a>
                    <a href="https://t.me/rustreamofficial" title="Telegram" target="_blank">
                        <Svg class="shrink-0 size-6" icon="telegram"/>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
