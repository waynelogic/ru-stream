<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {PhCheck, PhPencil, PhTrash, PhXCircle} from "@phosphor-icons/vue";
import {ref, watch} from "vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import Button from "@/Components/Actions/Button.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {basename} from "@/Utils/basename.js";
import VideoPlayer from "@/Components/Common/VideoPlayer.vue";

const props = defineProps({
    story: Object,
    isNew: {
        type: Boolean,
        default: false
    }
});

const form = useForm({
    title: props.story ? props.story.title : null,
    file: null,
})

const isEditing = ref(props.isNew);
const isLocked = ref(false);

const submit = () => {
    if (props.isNew) {
        form.post(route('stories.store'), {
            preserveScroll: true,
            onBefore: () => isLocked.value = true,
            onSuccess: () => {
                isLocked.value = false;
                form.reset();
            }
        });
    } else {
        form.put(route('stories.update', props.story.id), {
            preserveScroll: true,
            onBefore: () => isLocked.value = true,
            onSuccess: () => {
                isEditing.value = false;
                isLocked.value = false;
            }
        });
    }
}
const deleteVideo = () => {
    router.delete(route('stories.destroy', props.story.id), {
        preserveScroll: true,
        onBefore: () => confirm('Вы уверены, что хотите удалить видео?'),
    })
}

watch(() => form.file,(newFile) => {
    if (newFile) {
        form.title = basename(newFile.name).slice(0, 50);
    }
});
</script>

<template>
    <div :class="isLocked ? 'opacity-50 pointer-events-none' : ''" class="flex flex-col gap-2 box self-start overflow-hidden duration-150" :id="isNew ? 'new-video-card' : 'video-' + story.id">
        <form class="relative" @submit.prevent="submit" enctype="multipart/form-data">
            <VideoPlayer v-if="!isNew" :src="story.video_url" :poster="story.poster_url" :key="story.id"/>

            <template v-if="!isEditing">
                <div class="flex flex-col px-4 pt-4 w-full">
                    <h3 class="text-base font-semibold font-serif text-indigo-400">{{ story.title }}</h3>
                    <p v-if="story.description" class="text-sm">{{ story.description }}</p>
                </div>
            </template>

            <div class="flex flex-col gap-4 p-4">
                <!-- Inputs -->
                <template v-if="isEditing">
                    <label v-if="isNew" class="flex flex-col">
                        <input class="form-control" type="file" id="file" accept="video/*" required @input="form.file = $event.target.files[0]"/>
                        <span v-if="form.errors.file" class="text-sm">{{ form.errors.file }}</span>
                    </label>
                    <div class="flex flex-col">
                        <TextInput v-model="form.title" required name="title" type="text" placeholder="Название видео" maxlength="55"/>
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div class="flex flex-col">
                        <TextArea v-model="form.description" name="description" cols="30" rows="2" placeholder="Описание" maxlength="120" class="form-control w-full"></TextArea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                </template>
                <!-- Buttons -->
                <div class="flex gap-4">
                    <Button class="w-full" type="submit" :disabled="form.processing" v-if="isNew || isEditing">
                        <span>Сохранить</span>
                        <PhCheck class="size-5 ml-2"/>
                    </Button>
                    <Button type="button" v-if="!isNew"
                        :class="isEditing ? 'shrink-0' : 'w-full'"
                        :size="isEditing ? 'square' : 'md'"
                        :color="isEditing ? 'warning' : 'primary'"
                        @click="isEditing = !isEditing"
                    >
                        <span v-if="!isEditing" class="mr-2">Изменить</span>
                        <component :is="!isEditing ? PhPencil : PhXCircle" class="size-5"/>
                    </Button>
                    <Button type="button" color="danger" size="square" @click="deleteVideo" v-if="!isNew && !isEditing">
                        <PhTrash class="size-6"/>
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
