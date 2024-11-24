<script setup>
import {router, useForm} from "@inertiajs/vue3";
import {PhCheck, PhPencil, PhTrash, PhXCircle} from "@phosphor-icons/vue";
import {ref, watch} from "vue";
import TextInput from "@/Components/Form/TextInput.vue";
import InputError from "@/Components/Form/InputError.vue";
import Button from "@/Components/Actions/Button.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {basename} from "@/Utils/basename.js";

const props = defineProps({
    video: Object,
    isNew: {
        type: Boolean,
        default: false
    }
});

const form = useForm({
    title: props.video ? props.video.title : null,
    description: props.video ? props.video.description : null,
    file: null,
})

const isEditing = ref(props.isNew);

const submit = () => {
    if (props.isNew) {
        form.post(route('videos.store'), {
            preserveScroll: true,
            onSuccess: () => {
                console.log(1)
                form.reset();
            }
        });
    } else {
        form.put(route('videos.update', props.video.id), {
            preserveScroll: true,
            onSuccess: () => isEditing.value = false
        });
    }
}
const deleteVideo = () => {
    router.delete(route('videos.destroy', props.video.id), {
        preserveScroll: true,
        onBefore: () => confirm('Вы уверены, что хотите удалить видео?'),
    })
}

watch(form, () => form.file && (form.title = basename(form.file.name).slice(0, 50)))
</script>

<template>
    <div class="flex flex-col gap-2 box self-start  overflow-hidden" :id="isNew ? 'new-video-card' : 'video-' + video.id">
        <form class="relative" @submit.prevent="submit" enctype="multipart/form-data">
            <video v-if="!isNew" class="aspect-video w-full" width="100%" height="auto" :poster="video.poster_url" controls>
                <source :src="video.video_url" type="video/mp4">
            </video>
            <template v-if="!isEditing">
                <div class="flex flex-col px-4 pt-4 w-full">
                    <h3 class="text-base font-semibold font-serif text-indigo-400">{{ video.title }}</h3>
                    <p v-if="video.description" class="text-sm">{{ video.description }}</p>
                </div>
            </template>

            <div class="flex flex-col gap-4 p-4">
                <!-- Inputs -->
                <template v-if="isEditing">
                    <label v-if="isNew" class="flex flex-col">
                        <input class="form-control" placeholder="Выберите видео" type="file" id="file" accept="video/*" required @input="form.file = $event.target.files[0]"/>
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
