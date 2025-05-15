// Simple filter logic
document.getElementById('type-filter').addEventListener('change', function () {
    const selected = this.value;
    document.querySelectorAll('.product-item').forEach(item => {
        const sizes = item.getAttribute('data-type').split(',');
        if (selected === 'all' || sizes.includes(selected)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});