"use strict";

document.querySelector('#menuButton').addEventListener('click', menuMobile);

function menuMobile()
{
    var headerNav = document.querySelector('#headerNav');
    var displayCross = document.querySelector('#cross');
    var hideBurgerMenu = document.querySelector('#burgerMenu');
    headerNav.classList.toggle('openMenuMobile');
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
