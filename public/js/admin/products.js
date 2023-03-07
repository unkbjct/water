window.onload = () => {

    var fileList = new DataTransfer();
    let inputFile = document.getElementById("images");
    let select = document.getElementById("parent");

    // if (inputFile.files.length) {
    //     document.getElementById("image-preview").classList.add("imageAdded");
    //     buildImagePreview(inputFile.files);
    // }

    let images = document.getElementById("image-preview").dataset.images;
    if (images) {
        images = JSON.parse(images)
        images.forEach(async function (img, index) {

            createFile(window.location.protocol + '//' + window.location.host + '/' + img.url, index).then(file => {
                fileList.items.add(file);
                inputFile.files = fileList.files
            })

        })
    }


    if (select.value != "") {
        let data = select.options[select.selectedIndex].dataset.attributes;
        if (!data) return;
        data = JSON.parse(data);

        // console.log(data)

        data.forEach(function (attribute) {
            element =
                '<div class="attributes-item">' +
                '<div class="input-group">' +
                `<div class="input-group-text"> ${attribute.name} </div>` +
                '<input type="text" value="' + ((attribute.value) ? attribute.value : "") + `" id="attr-${attribute.id}" class="form-control" name="attributes[${attribute.id}]">` +
                '</div>' +
                `<div class="attribute-owner">Категория: <i>${attribute.owner}</i></div>` +
                '</div>';
            document.getElementById("attribute-list").insertAdjacentHTML("beforeend", element)
        })

        let values = JSON.parse(document.getElementById("attribute-list").dataset.attributesValue);
        values.forEach(val => {
            if (document.getElementById("attr-" + val.attribute)) {
                document.getElementById("attr-" + val.attribute).value = val.value
            }
        })

    }

    document.getElementById("parent").addEventListener("change", function () {
        let attributes = document.querySelectorAll(".attributes-item")
        attributes.forEach(function (attribute) {
            attribute.remove();
        })

        let data = this.options[this.selectedIndex].dataset.attributes;
        if (!data) return;
        data = JSON.parse(data);

        data.forEach(function (attribute) {
            element =
                '<div class="attributes-item">' +
                '<div class="input-group">' +
                `<div class="input-group-text"> ${attribute.name} </div>` +
                '<input type="text" value="' + ((attribute.value) ? attribute.value : "") + `" id="attr-${attribute.id}" class="form-control" name="attributes[${attribute.id}]">` +
                '</div>' +
                `<div class="attribute-owner">Категория: <i>${attribute.owner}</i></div>` +
                '</div>';
            document.getElementById("attribute-list").insertAdjacentHTML("beforeend", element)
        })

        let values = JSON.parse(document.getElementById("attribute-list").dataset.attributesValue);
        values.forEach(val => {
            if (document.getElementById("attr-" + val.attribute)) {
                document.getElementById("attr-" + val.attribute).value = val.value

            }
        })
    })

    document.getElementById("images").addEventListener("change", function () {

        if ((this.files.length + fileList.files.length) > 10) {
            this.files = fileList.files;
            alert('Максимум 10 изображений');
            return;
        }

        let list = document.getElementById("image-preview")

        list.classList.add("imageAdded")
        for (let i = 0; i < this.files.length; i++) {
            fileList.items.add(this.files[i]);

        }

        this.files = fileList.files;
        buildImagePreview(this.files)
    })

    document.getElementById("image-preview").addEventListener("click", function (e) {
        if (!e.target.classList.contains("remove-image")) return;
        fileList.items.remove(e.target.parentElement.getAttribute('data-id'))
        document.getElementById("images").files = fileList.files;
        buildImagePreview(fileList.files);

    })

    document.getElementById("add-inclusion").addEventListener("click", function () {
        if (!this.previousElementSibling.value) return;
        let list = document.querySelectorAll(".inclusion-item");
        // console.log(list)
        if (list) {
            let isRepeat = false;
            list.forEach(item => {
                if (item.getElementsByClassName("inclusion-title")[0].textContent == this.previousElementSibling.value) {
                    isRepeat = true;
                    return;
                }
            })
            if (isRepeat) return;
        }
        let element =
            '<div class="inclusion-item" >' +
            `<input type="hidden" name="inclusions[]" value="${this.previousElementSibling.value}">` +
            '<div class="d-flex justify-content-between">' +
            `<span class="inclusion-title" >${this.previousElementSibling.value}</span>` +
            '<button type="button" class="btn-close" aria-label="Close"></button>' +
            '</div>' +
            '</div>';
        document.getElementById("inclusion-list").insertAdjacentHTML("afterbegin", element);
        this.previousElementSibling.select();
    })

    document.getElementById("inclusion-list").addEventListener("click",  function(e){
        if(!e.target.classList.contains("btn-close")) return;
        e.target.parentElement.parentElement.remove();
    })


}

function buildImagePreview(files) {
    list = document.getElementById("image-preview");
    list.innerHTML = null;
    if (!files.length) {
        list.classList.remove("imageAdded");
        return;
    }

    for (let i = 0; i < files.length; i++) {
        list.insertAdjacentHTML(
            "beforeend",
            `<div class="image-item" data-id="${i}">` +
            `<img src="${URL.createObjectURL(files[i])}">` +
            '<button type="button" class="btn btn-danger btn-sm remove-image" aria-label="Close">Удалить</button>' +
            '</div>'
        )
    }
}

async function createFile(url, index) {
    let response = await fetch(url);
    let data = await response.blob();
    let metadata = {
        type: 'image/jpeg'
    };
    var file = new File([data], `${index}.jpg`, metadata);

    return file;
}

