const sidebar = document.getElementById('sidebar');
const resizer = document.getElementById('sidebarResizer');
const main = document.querySelector('.admin-main');

if (sidebar && resizer && main) {
    let isResizing = false;

    resizer.addEventListener('mousedown', function () {
        isResizing = true;
        document.body.style.cursor = 'col-resize';
        document.body.style.userSelect = 'none';
    });

    document.addEventListener('mousemove', function (e) {
        if (!isResizing) return;

        let newWidth = e.clientX;

        if (newWidth < 180) newWidth = 180;
        if (newWidth > 400) newWidth = 400;

        sidebar.style.width = newWidth + 'px';
        main.style.marginLeft = newWidth + 'px';
        main.style.width = `calc(100% - ${newWidth}px)`;

        localStorage.setItem('sidebarWidth', newWidth);
    });

    document.addEventListener('mouseup', function () {
        isResizing = false;
        document.body.style.cursor = 'default';
        document.body.style.userSelect = 'auto';
    });

    const savedWidth = localStorage.getItem('sidebarWidth');

    if (savedWidth) {
        sidebar.style.width = savedWidth + 'px';
        main.style.marginLeft = savedWidth + 'px';
        main.style.width = `calc(100% - ${savedWidth}px)`;
    }
}