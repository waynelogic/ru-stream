<template>
    <div class="container">
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 lg:mt-24">
            <div>
                <slot name="logo" />
            </div>

            <div class="box w-full sm:max-w-md mt-6 shadow-md overflow-hidden sm:rounded-2xl p-6">
                <slot />
            </div>
        </div>
    </div>
</template>
