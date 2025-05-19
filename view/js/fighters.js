document.querySelectorAll('.show').forEach(btn => {
            btn.addEventListener('click', function () {
                const info = this.closest('.fighter-profile').querySelector('.fighter-info');
                info.classList.toggle('active');
                this.textContent = info.classList.contains('active') ? 'Less info' : 'More info';
            });
        });