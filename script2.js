
/* @author Atom Alexander M. Nava
 * @brief It displays a specific form based on the form ID provided in the argument
 */

function showForm(formId) 
{
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}