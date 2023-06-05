import Pristine from "pristinejs";
import axios from "axios";

let form = document.querySelector(".form");
const initalTitleValue = document.getElementsByName("post_title")[0]?.value;

const live = false;

const config = {
    classTo: "form__field",
    errorClass: "is-invalid",
    successClass: "is-valid",
    errorTextParent: "form__field",
    errorTextTag: "div",
    errorTextClass: "form__error",
};

const pristine = new Pristine(form, config, live);

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let titleElement = document.getElementsByName("post_title")[0];
    titleElement.style.borderStyle = "none";
    axios
        .post("/posts/validate", titleElement.value)
        .then((response) => {
            return response.data.exists;
        })
        .then((slugExists) => {
            const pristineValid = pristine.validate();
            if (slugExists && titleElement.value !== initalTitleValue) {
                titleElement.parentElement.children[2].innerHTML =
                    "This name already exists";
                titleElement.parentElement.children[2].style.display = "block";
            } else if (pristineValid) {
                form.submit();
            }
        });
});
