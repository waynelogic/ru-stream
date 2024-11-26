const vVibrate = {
    mounted(el, { value }) {
        el.addEventListener('click', () => {
            if ('vibrate' in navigator) {
                navigator.vibrate(value || [30]);
            }
        });
    }
};

export default vVibrate;
