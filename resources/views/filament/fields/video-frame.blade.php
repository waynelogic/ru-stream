@php
    $url = $this->data['video_url'];
    if (empty($url)) {
        $answer =  "URL не может быть пустым.";
    } else {
        $substring = strstr($url, "https://vk.com/video-");

        if ($substring !== false) {
            $result = explode('_', substr($substring, strlen("https://vk.com/video-")));
        } else {
            $answer = "Строка 'https://vk.com/video-' не найдена в URL.";
        }
    }
@endphp

<section class="fi-section rounded-xl overflow-hidden bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="grid flex-1 gap-y-1">
                <h3
                    class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Предпросмотр видео
                </h3>
            </div>
        </div>
    </header>
    <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
        <div class="fi-section-content overflow-hidden">
            @if(isset($answer))
                <div class="p-6">
                    {{ $answer }}
                </div>
            @endif

            @if(isset($result))
                <iframe src="https://vk.com/video_ext.php?oid=-{{ $result[0] }}&id={{ $result[1] }}&hd=2" width="100%" height="300"
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen></iframe>
            @endif
        </div>
    </div>
</section>
