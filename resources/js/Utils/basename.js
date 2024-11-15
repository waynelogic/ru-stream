export const basename = (str, sep = '.') => {
    return str.split(sep).slice(0, -1).join(sep);
}
