console.log('js chargé');

document.addEventListener('DOMContentLoaded', () => {

    const quill = new Quill("#editor", {
        modules: { toolbar: "#toolbar" },
        placeholder: "Écrivez votre recette ici...",
        theme: "snow",
    });

    const existingContent = document.getElementById("contenu").value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // tooltips
    document.querySelector(".ql-bold").setAttribute("title", "Gras");
    document.querySelector(".ql-italic").setAttribute("title", "Italique");
    document.querySelector(".ql-underline").setAttribute("title", "Souligné");
    document.querySelector('.ql-list[value="ordered"]').setAttribute("title", "Liste numérotée");
    document.querySelector('.ql-list[value="bullet"]').setAttribute("title", "Liste à puces");

    // submit
    document.getElementById("form").addEventListener("submit", (e) => {
        const html = quill.root.innerHTML;
        document.getElementById("contenu").value = html;

        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault();
            alert("Veuillez écrire une recette avant d'envoyer");
        }
    });

});