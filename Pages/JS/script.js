const formPoppup = document.querySelector(".form"),
    forms = [...document.querySelectorAll(".form form")],
    erreur = document.querySelector(".erreur"),
    success = document.querySelector(".success"),
    ajouter = document.querySelector(".ajouter"),
    fermer = document.getElementById("fermer")

ajouter.addEventListener("click", () => {
    showHide(formPoppup)
})

fermer.addEventListener("click", () => {
    showHide(formPoppup)
})

forms.forEach(form => {
    form.addEventListener("submit", (e) => {
        e.preventDefault()
        insertion(form)
    })
})

function insertion(formulaire) {
    let formdata = new FormData(formulaire)
    let xhr = new XMLHttpRequest()
    xhr.open("POST", "/Pages/Admin/insertion.php", true)
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response
                if (data === "Success") {
                    showHide(formPoppup)
                    success.innerHTML = "<i class='fa-solid fa-square-check'></i><span>Ajout réussie</span>"
                    showHide(success)
                    setTimeout(() => {
                        // success.style.display = "none"
                        window.location.reload()
                    }, 2000)
                } else {
                    erreur.innerHTML = "<span><i class='fa-solid fa-triangle-exclamation'></i>" + data + "</span>"
                    erreur.style.display = "block"
                }
            }
        }
    }
    xhr.send(formdata)
}

function showHide(element) {
    if (element.style.display === "block") {
        element.style.display = "none";
        document.body.style.overflow = "auto"
    } else {
        element.style.display = "block";
        document.body.style.overflow = "hidden"
    }
}

// console.log(forms)