function showMessage(message, type = 'success') {
    let box = document.getElementById('message-box');

    if (!box) {
        box = document.createElement('div');
        box.id = 'message-box';
        document.body.prepend(box);
    }

    box.className = type === 'success' ? 'success' : 'error';
    box.textContent = message;
    box.style.display = 'block';

    clearTimeout(box.timeoutId);
    box.timeoutId = setTimeout(() => {
        box.style.display = 'none';
    }, 4000);
}



// Load pages dynamically into #main-content
function loadPage(url) {
    const mainContent = document.getElementById('main-content');

    fetch(url)
        .then(res => {
            if (!res.ok) throw new Error('Network error: ' + res.status);
            return res.text();
        })
        .then(html => {
            mainContent.innerHTML = html;

            const scripts = mainContent.querySelectorAll('script');
            scripts.forEach(script => {
                const newScript = document.createElement('script');
                if (script.src) {
                    newScript.src = script.src;
                    newScript.async = false;
                } else {
                    newScript.textContent = script.textContent;
                }
                document.body.appendChild(newScript);
            });

            attachFormSubmitHandler();
        })
        .catch(err => {
            mainContent.innerHTML = `<p style="color:red;">Error loading page: ${err.message}</p>`;
        });
}

// Attach form submit handlers
function attachFormSubmitHandler(formId, actionUrl) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
             const formData = new FormData(form);
            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                credentials: 'include' // ✅ Necessary for sessions to work
            })

            .then(response => response.text())
            .then(responseHTML => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = responseHTML;

                const alertSuccess = tempDiv.querySelector('.alert-success');
                const alertError = tempDiv.querySelector('.alert-danger');

                document.getElementById('main-content').innerHTML = responseHTML;

                if (alertSuccess) {
                    showMessage(alertSuccess.textContent.trim(), 'success');
                } else if (alertError) {
                    showMessage(alertError.textContent.trim(), 'error');
                }

                attachFormSubmitHandler(formId, actionUrl);
            })
            .catch(err => {
                document.getElementById('main-content').innerHTML =
                    `<p style="color:red;">Error submitting form: ${err.message}</p>`;
            });
        });
    }
}

// Attach handlers for each specific form on load
attachFormSubmitHandler('academics-form', 'academics.php');
attachFormSubmitHandler('post-job-form', 'post_job.php');

attachFormSubmitHandler('page-form', 'page.php');
attachFormSubmitHandler('apply-form', 'advertised_jobs.php');
attachFormSubmitHandler('submit-form', 'submit_application.php');
attachFormSubmitHandler('employment-form', 'employment.php');
attachFormSubmitHandler('status-form', 'status.php');
attachFormSubmitHandler('membership-form', 'membership.php');
attachFormSubmitHandler('referees-form', 'referees.php');
attachFormSubmitHandler('professional-form', 'professional_bodies.php');
attachFormSubmitHandler('personal-form', 'personal_info.php');
attachFormSubmitHandler('courses-form', 'other_courses.php');
attachFormSubmitHandler('editModal', 'edit_job.php');
attachFormSubmitHandler('deleteModal', 'delete_job.php');