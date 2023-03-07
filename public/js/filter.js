window.onload = () => {
    document.querySelector(".btn-show-filters").addEventListener("click", function() {
        document.querySelector(".filter-col").classList.add("active-mobile-filter")
        document.querySelector("body").style.overflow = 'hidden';
        document.querySelector(".custom-fade").style.zIndex = '5';
        document.querySelector(".custom-fade").style.display = 'block';
    })

    document.querySelector(".btn-hide-filters").addEventListener("click", function(){
        document.querySelector(".filter-col").classList.remove("active-mobile-filter")
        document.querySelector("body").style.overflow = 'auto';
        document.querySelector(".custom-fade").style.zIndex = '-10';
        document.querySelector(".custom-fade").style.display = 'none';
    })
}