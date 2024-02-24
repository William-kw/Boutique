const form = document.querySelector("form"),
    subBtn = document.querySelector("form input[type='submit']"),
    erreur = document.querySelector(".erreur"),
    erreurC = document.querySelector(".erreurC"),
    mdp = document.getElementById("mdp"),
    showmdp = document.getElementById("showmdp"),
    masqmdp = document.getElementById("masqmdp"),
    fermer = document.getElementById("#fermer"),
    tab = document.querySelector("table")

form.onsubmit = (e) => {
    e.preventDefault()
}

subBtn.onclick = () => {
    let formdata = new FormData(form)
    let xhr = new XMLHttpRequest()
    xhr.open("POST", "/Pages/traitement.php", true)
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response
                if (data === "Admin") {
                    location.href = "/Pages/" + data + "/index.php"
                } else if (data === "User") {
                    location.href = "/Pages/" + data + "/index.php"
                } else {
                    erreur.innerHTML = "<i class='fa-solid fa-xmark' onclick='masquer(erreur)' id='fermer'></i><span><i class='fa-solid fa-triangle-exclamation'></i>" + data + "</span>"
                    erreur.style.display = "block"
                }
            }
        }
    }
    xhr.send(formdata)
}

function showpassword() {
    showmdp.addEventListener('click', () => {
        if (mdp.type === "password") {
            mdp.type = "text"
            showmdp.style.display = "none"
            masqmdp.style.display = "block"
        } else {
            mdp.type = "password"
            showmdp.style.display = "block"
            masqmdp.style.display = "none"
        }
    })
    masqmdp.addEventListener('click', () => {
        if (mdp.type === "password") {
            mdp.type = "text"
            showmdp.style.display = "none"
            masqmdp.style.display = "block"
        } else {
            mdp.type = "password"
            showmdp.style.display = "block"
            masqmdp.style.display = "none"
        }
    })
}
showpassword()

function masquer(element) {
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}