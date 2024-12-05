<script setup>
import { ref, onMounted } from 'vue';

const canvas = ref(null); // Ссылка на элемент canvas

const createSnow = () => {
    const ctx = canvas.value.getContext('2d');

    // Добавляем проверку на существование canvas.value
    if (!canvas.value || !ctx) {
        return;
    }
    const snowflakes = [];
    const maxSnowflakes = 100;
    let animationFrame;

    // Функция создания снежинки
    const createSnowflake = () => ({
        x: Math.random() * canvas.value.width, // Случайная позиция X
        y: Math.random() * canvas.value.height, // Случайная позиция Y
        radius: Math.random() * 4 + 1, // Радиус снежинки
        speed: Math.random() * 3 + 1, // Скорость падения
        opacity: Math.random(), // Прозрачность снежинки
    });

    // Функция инициализации снежинок
    const initializeSnowflakes = () => {
        snowflakes.length = 0; // Очистка массива
        for (let i = 0; i < maxSnowflakes; i++) {
            snowflakes.push(createSnowflake());
        }
    };

    // Обновление позиции снежинок
    const updateSnowflakes = () => {
        snowflakes.forEach((snowflake) => {
            snowflake.y += snowflake.speed;
            if (snowflake.y > canvas.value.height) {
                // Если снежинка вышла за нижнюю границу
                snowflake.y = -snowflake.radius;
                snowflake.x = Math.random() * canvas.value.width; // Новая случайная X
            }
        });
    };

    // Отрисовка снежинок
    const drawSnowflakes = () => {
        ctx.clearRect(0, 0, canvas.value.width, canvas.value.height); // Очистка холста
        ctx.fillStyle = 'white';
        snowflakes.forEach((snowflake) => {
            ctx.globalAlpha = snowflake.opacity;
            ctx.beginPath();
            ctx.arc(snowflake.x, snowflake.y, snowflake.radius, 0, Math.PI * 2);
            ctx.fill();
        });
    };

    // Анимация
    const animate = () => {
        updateSnowflakes();
        drawSnowflakes();
        animationFrame = requestAnimationFrame(animate);
    };

    // Установка размеров канваса и переинициализация снежинок
    const resizeCanvas = () => {
        canvas.value.width = window.innerWidth;
        canvas.value.height = window.innerHeight;
        initializeSnowflakes(); // Переинициализируем снежинки под новые размеры
    };

    // Инициализация
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
    animate();

    // Очистка при удалении компонента
    return () => {
        cancelAnimationFrame(animationFrame);
        window.removeEventListener('resize', resizeCanvas);
    };
};

onMounted(() => {
    createSnow();
});
</script>



<template>
    <div class="snow-container">
        <canvas ref="canvas" width="100" height="100"></canvas>
    </div>
</template>

<style scoped lang="postcss">
.snow-container {
    @apply fixed inset-0 pointer-events-none opacity-30;
}

canvas {
    display: block;
}
</style>
