window.onload = function () {

    let reviewStars = document.querySelectorAll(".review-star");

    reviewStars.forEach(function (star) {
        star.addEventListener("click", function () {
            reviewStars.forEach(oldStar => {
                oldStar.style.color = null;
            })
            star.parentElement.classList.remove("validation-error")
            for (let i = 0; i < star.dataset.score; i++) {
                reviewStars[i].style.color = "#ffc107";
            }
            document.getElementById("raiting").value = star.dataset.score;
        })
    })

    document.getElementById("btn-create-review").addEventListener("click", function () {
        // console.log((Boolean)(document.getElementById("raiting").value))
        document.querySelectorAll(".need-validation").forEach(input => {
            input.classList.remove("validation-error")
        })
        errs = [];
        if (!document.getElementById("raiting").value) errs.push("review-stars");
        if (!document.getElementById("advantages").value) errs.push("advantages");
        if (!document.getElementById("flaw").value) errs.push("flaw");
        if (!document.getElementById("comment").value) errs.push("comment");


        if (errs.length) {
            errs.forEach(id => {
                document.getElementById(id).classList.add("validation-error");
            })
            return;
        }
        document.getElementById("form-review").submit()

    })

    const swiperSuggestionsBrand = document.querySelector('.swiper-suggestions-brand')
    if (swiperSuggestionsBrand) {
        Object.assign(swiperSuggestionsBrand, {
            slidesPerView: 2,
            spaceBetween: 10,
            dots: false,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 5,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        });
        swiperSuggestionsBrand.initialize();
    }

    const swiperWatched = document.querySelector('.swiper-watched')
    if (swiperWatched) {
        Object.assign(swiperWatched, {
            slidesPerView: 2,
            spaceBetween: 10,
            dots: false,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 5,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        });
        swiperWatched.initialize();
    }


}