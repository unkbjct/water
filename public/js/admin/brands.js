window.onload = function() { 
    document.querySelectorAll(".btn-remove-modal").forEach(btn => {
        btn.addEventListener("click", function(){
            let brand = JSON.parse(this.parentElement.dataset.brand);
            document.getElementById("currentBrand").textContent = brand.name;
            document.getElementById("id-remove").value = brand.id;
        })
    })

    document.querySelectorAll(".btn-change").forEach(btn => {
        btn.addEventListener("click", function(){
            document.getElementById("collapseCreate").classList.remove("show")
            let brand = JSON.parse(this.parentElement.dataset.brand);
            document.getElementById("id-change").value = brand.id;
            document.getElementById("name-change").value = brand.name;
            // document.getElementById("currentBrand").textContent = brand.name
            document.getElementById("collapseChange").classList.add("show")
        })
    })
    
    

}