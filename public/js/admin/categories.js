window.onload = () => {
    // alert()
    let select = document.getElementById("parent");
    if (select.value != '') {
        let list = document.getElementById("attribute-list");

        let data = select.options[select.selectedIndex].dataset.attributes;
        data = JSON.parse(data);
        data.forEach(function (attribute) {
            element =
                '<div class="attributes-item attribute-item-parent" >' +
                '<div class=""><b>' + attribute.name + '</b></div>' +
                '<div class="attribute-owner"><i>' + attribute.owner + '</i></div>' +
                '</div >';
            list.insertAdjacentHTML("beforeend", element)
        })
    }

    document.getElementById("btn-add-attribute").addEventListener("click", function () {

        let input = document.getElementById("add-attribute"),
            items = document.querySelectorAll(".attributes-item"),
            repeat = false;

        items.forEach(function (item) {
            if (repeat) return;
            if (item.textContent == input.value) repeat = !repeat;
        })

        if (repeat || input.value == "") {
            input.select();
            return;
        }

        let element =
            '<div class="attributes-item" >' +
            '<div class="me-4">' + input.value + '</div>' +
            '<input type="hidden" value="' + input.value + '" name="attributes[' + input.value + ']">' +
            '<button type="button" class="btn-remove-attribute btn-close" aria-label="Close"></button>' +
            '</div >';
        document.getElementById("attribute-list").insertAdjacentHTML("afterbegin", element)
        input.select();
    })

    document.getElementById("attribute-list").addEventListener("click", function (e) {
        if (!e.target.classList.contains("btn-remove-attribute")) return;
        e.target.parentElement.remove();
    })

    document.getElementById("parent").addEventListener("change", function () {

        let attributes = document.querySelectorAll(".attribute-item-parent")
        attributes.forEach(function (attribute) {
            attribute.remove();
        })

        let list = document.getElementById("attribute-list");

        let data = this.options[this.selectedIndex].dataset.attributes;
        data = JSON.parse(data);
        data.forEach(function (attribute) {
            element =
                '<div class="attributes-item attribute-item-parent" >' +
                '<div class=""><b>' + attribute.name + '</b></div>' +
                '<div class="attribute-owner"><i>' + attribute.owner + '</i></div>' +
                '</div >';
            list.insertAdjacentHTML("beforeend", element)
        })
    })

    if (document.getElementById("btn-reset")) {
        document.getElementById("btn-reset").addEventListener("click", function () {
            let attributes = document.querySelectorAll(".attributes-item");
            attributes.forEach(attribute => {
                if (attribute.classList.contains('attribute-item-parent')) return;
                attribute.remove()
            })

            data = JSON.parse(document.getElementById("attribute-list").dataset.thisAttributes);

            data.forEach(function (attribute) {
                let element =
                    '<div class="attributes-item" >' +
                    '<div class="me-4">' + attribute.name + '</div>' +
                    '<input type="hidden" value="' + attribute.name + '" name="attributes[' + attribute.name + ']">' +
                    '<button type="button" class="btn-remove-attribute btn-close" aria-label="Close"></button>' +
                    '</div >';
                document.getElementById("attribute-list").insertAdjacentHTML("afterbegin", element)
            })

        })
    }
}