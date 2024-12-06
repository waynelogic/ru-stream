const vVibrate = {
    mounted(el, { value }) {
        el.addEventListener('click', () => {
            if ('vibrate' in navigator) {
                navigator.vibrate(value || 100);
            }
        });
    }
};

export default vVibrate;
