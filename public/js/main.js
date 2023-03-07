window.addEventListener("load", (event) => {
    // document.getElementById("show-catalog-nav").addEventListener("click", function () {

    //     let nav = document.getElementById("catalog-nav")
    //     if (nav.classList.contains("active-catalog-nav")) {
    //         nav.classList.remove("active-catalog-nav")
    //     } else {
    //         nav.classList.add("active-catalog-nav")
    //     }
    // })

    // document.getElementById("close-catalog-nav").addEventListener("click", function () {
    //     document.getElementById("catalog-nav").classList.remove("active-catalog-nav")
    // })

    document.querySelectorAll(".add-to-favorites").forEach(favorite => {
        favorite.addEventListener("click", function () {
            var favorites = getCookie('favorites');
            var product = JSON.parse(this.dataset.product);

            if (!this.classList.contains("activeFavorite")) {
                this.classList.add("activeFavorite");
                if (favorites) {
                    favorites = favorites.split(',');
                    favorites.push(product.id)
                    document.cookie = 'favorites=' + favorites + ";path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
                } else {
                    console.log(favorites)
                    favorites = [product.id]
                    document.cookie = 'favorites=' + favorites + ";path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
                }
                document.getElementById("favoriute-count").classList.remove("visually-hidden")
            } else {
                this.classList.remove("activeFavorite");
                favorites = favorites.split(',');
                const index = favorites.indexOf((String)(product.id));
                if (index > -1) favorites.splice(index, 1);
                document.cookie = 'favorites=' + favorites + ";path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
                if (favorites.length == 0) document.getElementById("favoriute-count").classList.add("visually-hidden")

            }
            document.getElementById("favoriute-count").textContent = favorites.length

        })
    })

});


function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}