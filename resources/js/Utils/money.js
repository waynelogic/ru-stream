export const money = (value, ) => {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        maximumFractionDigits: 0,
        currency: 'RUB'
    }).format(value);
}
