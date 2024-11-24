<script setup>
import {usePage} from "@inertiajs/vue3";
import {PhBell} from "@phosphor-icons/vue";
import {computed, onMounted, ref, watch} from "vue";

const page = usePage();

const sessionFlash = computed({
    get() {
        return page.props.flashy
    },
    set(newValue) {
        page.props.flashy = newValue
    }
})

const flash = ref()
const clear = () => {
    flash.value = null
}

onMounted(() => {
    window.addEventListener('flash', (e) => {
        sessionFlash.value = e.detail
    })
})
watch(sessionFlash, () => {
    if (sessionFlash.value) {

        flash.value = sessionFlash.value
        sessionFlash.value = null

        setTimeout(() => {
            clear();
        }, 3000);
    }
})
</script>

<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-50">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="flash"
                     :class="{'bg-red-600': flash.type === 'error', 'bg-green-600': flash.type === 'success', 'bg-indigo-500': flash.type === 'info'}"
                     class="border border-white/20 flex items-center rounded-xl shadow-lg mb-4 py-2 px-3 px text-white cursor-pointer">
                    <div class="w-full font-bold">
                        {{ flash.message }}
                    </div>
                    <div :class="{'bg-red-700': flash.type === 'error', 'bg-green-700': flash.type === 'success', 'bg-indigo-600': flash.type === 'info'}"
                         class="text-2xl p-2 rounded-full ml-4">
                        <PhBell class="size-6" />
                    </div>
                </div>
<!--                <div v-if="flash" class="box bg-primary-800 pointer-events-auto w-full max-w-sm overflow-hidden shadow-lg ring-1 ring-black ring-opacity-5">-->
<!--                    <div class="p-4">-->
<!--                        <div class="flex" :class="flash.description ? 'items-start' : 'items-center'">-->
<!--                            <div class="flex-shrink-0">-->
<!--                                <PhCheck class="h-6 w-6 text-green-400" aria-hidden="true" />-->
<!--                            </div>-->
<!--                            <div class="ml-3 w-0 flex-1 pt-0.5">-->
<!--                                <p class="text-sm font-medium text-white">{{ flash.message }}</p>-->
<!--&lt;!&ndash;                                <p class="mt-1 text-sm text-gray-500">Anyone with a link can now view this file.</p>&ndash;&gt;-->
<!--                            </div>-->
<!--                            <div class="ml-4 flex flex-shrink-0">-->
<!--                                <button type="button" @click="clear" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">-->
<!--                                    <span class="sr-only">Close</span>-->
<!--                                    <PhX class="h-5 w-5" aria-hidden="true" />-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </transition>
        </div>
    </div>
</template>

<style scoped>

</style>
