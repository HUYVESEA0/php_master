const 
    body = document.querySelector('body');
    sildebar = body.querySelector('.slidebar');
    toggle = body.querySelector('.toggle');
    searchBtn = body.querySelector('.search-box');
    modeSwitch = body.querySelector('.toggle-switch');
    modeText = body.querySelector('.mode-text');
    time = body.querySelector('.timer');
    main_content = body.querySelector('.main-content');
    icon = body.querySelector('.icon-switch');

    toggle.addEventListener('click', () => {
        sildebar.classList.toggle('close');
        main_content.classList.toggle('full');

        if (sildebar.classList.contains('close')) {
            icon.classList.replace('bx-chevron-left', 'bx-chevron-right');
        } else {
            icon.classList.replace('bx-chevron-right', 'bx-chevron-left');
        }
    });

    modeSwitch.addEventListener('click', () => {
        body.classList.toggle('dark');
        modeText.textContent = body.classList.contains('dark') ? 'Light Mode' : 'Dark Mode';
    });

/*time-date*/
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    time.textContent = `${hours}:${minutes}:${seconds}`;
}

setInterval(updateTime, 1000);
updateTime();