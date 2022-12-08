function handleRecover(form) {
    u = form.username.value;
    if (u !== '') {
        form.submit();
        window.location.href = '?pr=Li9wYWdlcy91c2Vycy9yZWNvdmVyeS90a3AvaW5kZXgucGhw';
        // alert('Recovering your Password');
    } else
        alert('Please, type your username or e-mail');
}