"use strict";

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
