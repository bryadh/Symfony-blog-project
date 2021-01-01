const article = document.getElementById('article-block');
if(article){
    article.addEventListener('click',(e) => {

        if(e.target.id === 'delete-article'){
            if(confirm('are you sure you want to delete this article ?')){
                const id = e.target.getAttribute('data-id');

                fetch(`/crud/delete/${id}`, { method : 'DELETE'}).then(res => window.location.href = "/");
            }
        }
    })
}
