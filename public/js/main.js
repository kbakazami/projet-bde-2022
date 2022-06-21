"use strict";

/************************* Mobile Menu ********************************/
const hamburgerMenu = document.querySelector(".hamburger-menu");
const navMenu = document.querySelector(".nav-menu");
const displayCross = document.querySelector('#cross');
const hideBurgerMenu = document.querySelector('#burgerMenu');

hamburgerMenu.addEventListener('click', menuMobile);

function menuMobile()
{
    navMenu.classList.toggle("active");

    hideBurgerMenu.classList.toggle('hidden');
    if(hideBurgerMenu.classList.contains('hidden'))
    {
        displayCross.classList.add('block');
        displayCross.classList.remove('hidden');
    }
    else
    {
        displayCross.classList.remove('block');
        displayCross.classList.add('hidden');
    }

}

/************************* Display Selected Image ********************************/
const chooseFile = document.querySelector("#file");
const imgPreview = document.querySelector("#img-preview");
const editImagePreview = document.querySelector("#edit-image-preview");
const hideImageInBdd = document.querySelector("#image-in-bdd");

chooseFile.addEventListener("change", function () {
    getImgData();
});

function getImgData() {
    const files = chooseFile.files[0];
    if (files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(files);
        fileReader.addEventListener("load", function () {
            hideImageInBdd.classList.add("hidden");
            editImagePreview.classList.remove("hidden");
            imgPreview.style.display = "block";
            imgPreview.innerHTML = '<img src="' + this.result + '" />';
            // imageUserPreview.innerHTML = '<img class="border-2 border-white rounded-full w-32 h-32" src="' + this.result + '" />';

        });
    }
}

/************************* Display Selected Image User ********************************/
const imageUserPreview = document.querySelector("#image-user-preview");
const choosePicture = document.querySelector(" #file");

choosePicture.addEventListener("change", getUserImgData)

function getUserImgData()
{
    const files = choosePicture.files[0];
    if(files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(files);
        fileReader.addEventListener("load", function () {
            imageUserPreview.style.backgroundImage = "url('"+  this.result +"')";
            // imageUserPreview.innerHTML = '<img class="border-2 border-white rounded-full w-32 h-32" src="' + this.result + '" />';

        });
    }
}

/************************* Display Input To Change Password ********************************/
const checkboxDisplay = document.querySelector("#checkboxChangePassword");
const divPassword = document.querySelector("#divPassword");
checkboxDisplay.addEventListener("click", displayDivPassword);

function displayDivPassword()
{
    divPassword.classList.toggle("hidden");
}



/************************* Disable Input In Edit User ********************************/
// const disabledInput = document.querySelector(".disabledInput");
// const childDivDisabledInput = disabledInput.querySelectorAll(":scope > .form-group");
// const childDisabledInput = childDivDisabledInput.querySelectorAll(":scope > .form-control");
//
// for (var inputChild of childDisabledInput)
// {
//     inputChild.setAttribute('disabled');
// }