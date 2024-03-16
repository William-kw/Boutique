const modif = document.querySelector(".modif-form"),
    form = [...document.querySelectorAll(".modif-form form")],
    erreur = document.querySelector(".erreur"),
    success = document.querySelector(".success")

form.forEach(formM => {
    formM.addEventListener("submit", (event) => {
        event.preventDefault()
        modifier(formM)
    })
})

function modifier(formulaire) {
    if (confirm("Enregistrer les modifications ?")) {
        let formdata = new FormData(formulaire)
        let xhr = new XMLHttpRequest()
        xhr.open("POST", "/Pages/Admin/update.php", true)
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response
                    switch (data) {
                        case "recette":
                            location.href = "/Pages/Admin/recette.php"
                            break;
                        case "achat":
                            location.href = "/Pages/Admin/achat.php"
                            break;
                        case "depense":
                            location.href = "/Pages/Admin/depense.php"
                            break;
                        case "charge":
                            location.href = "/Pages/Admin/charge.php"
                            break;
                        case "fournisseur":
                            location.href = "/Pages/Admin/fournisseur.php"
                            break;
                        case "ristourne":
                            location.href = "/Pages/Admin/ristourne.php"
                            break;
                        case "profil":
                            location.href = "/Pages/Admin/profil.php"
                            break;
                        case "Success":
                            success.innerHTML = "<i class='fa-solid fa-square-check'></i><span>Informations mises à jours</span>"
                            showHide(success)
                            setTimeout(() => {
                                success.style.display = "none"
                                window.location.reload()
                            }, 3000)
                            break;
                        case "mdp":
                            success.innerHTML = "<i class='fa-solid fa-square-check'></i><span>Informations mises à jours</span>"
                            showHide(success)
                            setTimeout(() => {
                                alert("Vous allez être déconnecté")
                                location.href = "/Pages/deconnexion.php"
                                success.style.display = "none"
                            }, 3000)
                            break;

                        default:
                            erreur.innerHTML = "</i><span><i class='fa-solid fa-triangle-exclamation'></i>" + data + "</span>"
                            erreur.style.display = "block"
                            break;
                    }
                }
            }
        }
        xhr.send(formdata)
    }
}

function previewFile() {
    const preview = document.querySelector('#pp'),
        file = document.querySelector('#input_pp').files[0],
        reader = new FileReader()

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function showHide(element) {
    if (element.style.display === "block")
        element.style.display = "none"
    else element.style.display = "block"
}

// console.log(form)