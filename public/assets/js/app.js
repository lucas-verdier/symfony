'use strict'


document.addEventListener('DOMContentLoaded', function loaded() {
    enableDropdowns()

})

const enableDropdowns = () => {
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl))
}