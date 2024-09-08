function verificarImagem(){
    const imagens = document.querySelectorAll('.noticia-imagem');

    imagens.forEach(imagem => {
        // Verifica se o atributo src da imagem não está vazio
        if (imagem.getAttribute('src') !== "") {
            imagem.style.display = 'block'; // Mostra a imagem
        } else {
            imagem.style.display = 'none'; // Oculta a imagem
        }
    });

}

function exibirCategorias(){
    let categorias=document.querySelector(".nav-popup")
    categorias.style.display="block"
}

function fecharCategorias(){
    let categorias=document.querySelector(".nav-popup")
    categorias.style.display="none"
}