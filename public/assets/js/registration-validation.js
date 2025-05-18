document.addEventListener('DOMContentLoaded', () => {
    const errors = Array.from(document.querySelectorAll('.error-message'));
    const inputs = Array.from(document.querySelectorAll('input[name="username"], input[name="email"], input[name="password"]'));

    let shownIndex = -1;

    for(let i = 0; i < errors.length; i++) {
        if(errors[i].textContent.trim() !== '') {
            errors[i].style.display = 'block';
            inputs[i].focus();
            shownIndex = i;
            break;
        }
    }

    if(shownIndex === -1) return;

    inputs[shownIndex].addEventListener('input', () => {
        errors[shownIndex].style.display = 'none';

        let nextIndex = -1;
        for(let j = shownIndex + 1; j < errors.length; j++) {
            if(errors[j].textContent.trim() !== '') {
                nextIndex = j;
                break;
            }
        }

        if(nextIndex !== -1) {
            errors[nextIndex].style.display = 'block';
            inputs[nextIndex].focus();
            shownIndex = nextIndex;
        }
    });
});
