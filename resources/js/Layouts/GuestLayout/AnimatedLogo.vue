<script setup>

</script>

<template>
    <div class="logo lg:text-3xl"><b><span class="text-primary-300">RU</span><span class="blink">:</span>S<span class="blink">T</span>REAM</b></div>
</template>

<style scoped>
.logo{
    color: #fee;
    text-shadow: 0 -40px 100px, 0 0 2px, 0 0 1em #9e61ff, 0 0 0.5em rgba(142, 97, 255, 0.36), 0 0 0.01em #619bff, 0 10px 5px rgba(108, 82, 238, 0.45);
}
.logo .blink{
    animation: blink linear infinite 2s;
}
.logo .blink:nth-of-type(2){
    animation: blink linear infinite 3s;
}
@keyframes blink {
    78% {
        color: inherit;
        text-shadow: inherit;
    }
    79%{
        color: #333;
    }
    80% {

        text-shadow: none;
    }
    81% {
        color: inherit;
        text-shadow: inherit;
    }
    82% {
        color: #333;
        text-shadow: none;
    }
    83% {
        color: inherit;
        text-shadow: inherit;
    }
    92% {
        color: #333;
        text-shadow: none;
    }
    92.5% {
        color: inherit;
        text-shadow: inherit;
    }
}
</style>
