export default (value) => {
    if (value) {
        value = value.trim();
    }
    const currentValue = value;

    if (currentValue.length > 11) {
        return currentValue.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }

    return currentValue.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
};
