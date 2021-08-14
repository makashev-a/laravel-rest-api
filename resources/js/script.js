window.addEventListener('DOMContentLoaded', () => {
    async function getData(url = '') {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        return await response.json();
    }

    const articles = document.querySelector('.articles');

    function addBtnEvents() {
        const moreBtn = document.querySelectorAll('.more'),
            fullPost = document.querySelector('#full-article'),
            articleTitle = document.querySelector('#title'),
            articleContent = document.querySelector('#content');

        moreBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                fullArticle(btn.getAttribute('data-id')).then((data) => {
                    articleTitle.textContent = '';
                    articleContent.textContent = '';
                    articleTitle.append(data.title);
                    articleContent.append(data.content);
                    fullPost.classList.remove('d-none');
                });
            });
        });

        const modalBtn = document.querySelectorAll('#modalBtn'),
            titleUpdate = document.querySelector('#title-update'),
            contentUpdate = document.querySelector('#content-update'),
            idUpdate = document.querySelector('#id-update');

        modalBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                fullArticle(btn.getAttribute('data-id')).then((data) => {
                    titleUpdate.setAttribute('value', data.title);
                    contentUpdate.textContent = data.content;
                    idUpdate.setAttribute('value', data.id);
                });
            });
        });

        const modalDelete = document.querySelectorAll('#modalDelete');
        modalDelete.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                const id = e.target.parentElement.querySelector('.more').getAttribute('data-id');
                fullArticle(id)
                    .then((data) => {
                        setFieldsForModalDelete(id, data.title);
                    });
            });
        });
    }

    function render(data) {
        for (let index in data) {
            articles.insertAdjacentHTML('afterbegin', `
                <div class="col-md-3 my-2">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">${data[index].title}</h5>
                            <p class='card-text'>${data[index].content.slice(0, 40)}...</p>
                            <button class="btn btn-primary more" data-id="${data[index].id}">More</button>
                            <button class="btn btn-success" id="modalBtn" data-bs-toggle="modal" data-bs-target="#update" data-id="${data[index].id}">Update</button>
                            <button class="btn btn-danger" id="modalDelete" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
                        </div>
                    </div>
                </div>
                `);
        }
        addBtnEvents();
    }

    getData('/api/articles')
        .then((data) => {
            render(data);
        });

    async function fullArticle(id) {
        const response = await fetch('/api/articles/' + id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        return await response.json();
    }

    const title = document.querySelector('.title'),
        content = document.querySelector('.content');

    async function storeArticle(url = '/api/articles', data = {}) {

        data = {
            title: title.value,
            content: content.value
        };

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })

        const titleError = document.querySelector('#title-error');
        const contentError = document.querySelector('#content-error');
        titleError.classList.add('d-none');
        contentError.classList.add('d-none');

        if (!response.ok) {
            let result = await response.json();

            for (let key in result.errors) {
                let errorText = result.errors[key];
                document.querySelector(`#${key}-error`).classList.remove('d-none');
                document.querySelector(`#${key}-error`).textContent = errorText;
            }
        } else if (response.ok) {
            return await response.json();
        }

    }

    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        storeArticle()
            .then((data) => {
                title.value = '';
                content.value = '';

                if (data) {
                    articles.insertAdjacentHTML('afterbegin', `
                <div class="col-md-3 my-2">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">${data.article.title}</h5>
                            <p class='card-text'>${data.article.content.slice(0, 40)}...</p>
                            <button class="btn btn-primary more" data-id="${data.article.id}">More</button>
                            <button class="btn btn-success" id="modalBtn" data-bs-toggle="modal" data-bs-target="#update" data-id="${data.article.id}">Update</button>
                            <button class="btn btn-danger" id="modalDelete" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
                        </div>
                    </div>
                </div>
                `);

                    addBtnEvents();
                }

            })
    });

    async function updateArticle() {
        const title = document.querySelector('#title-update').value,
            content = document.querySelector('#content-update').value,
            id = document.querySelector('#id-update').getAttribute('value');

        const data = {
            title: title,
            content: content
        };

        const response = await fetch('/api/articles/' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        return await response.json();
    }

    async function refreshData(data) {
        const cards = document.querySelectorAll('.articles .card');
        cards.forEach((card) => {
            if (data.id === parseInt(card.querySelector('.more').getAttribute('data-id'))) {
                const title = card.querySelector('.card-title'),
                    content = card.querySelector('.card-text');

                title.textContent = data.title;
                content.textContent = data.content.slice(0, 40) + '...';
            }
        });

        const articleTitle = document.querySelector('#title'),
            articleContent = document.querySelector('#content');

        articleTitle.textContent = '';
        articleContent.textContent = '';
        articleTitle.append(data.title);
        articleContent.append(data.content);

        const modalBtn = document.querySelectorAll('#modalBtn'),
            titleUpdate = document.querySelector('#title-update'),
            contentUpdate = document.querySelector('#content-update');

        modalBtn.forEach((btn) => {
            btn.addEventListener('click', () => {
                fullArticle(btn.getAttribute('data-id'))
                    .then((data) => {
                        if (parseInt(btn.getAttribute('data-id')) === data.id) {
                            titleUpdate.value = data.title;
                            contentUpdate.value = data.content;
                        }
                    });
            })
        });
    }

    const save = document.querySelector('#save');

    save.addEventListener('click', (e) => {
        updateArticle()
            .then((data) => {
                if (data) {
                    fullArticle(data.article.id)
                        .then((data) => {
                            refreshData(data);
                        })
                }
            });
    });

    function setFieldsForModalDelete(id, title) {
        const deleteId = document.querySelector('#delete-id');
        deleteId.setAttribute('value', id);
        const deleteTitle = document.querySelector('#delete-title');
        deleteTitle.textContent = title;
    }

    async function deleteArticle() {
        const id = document.querySelector('#delete-id').getAttribute('value');
        const response = await fetch('/api/articles/' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })

        return await response.json();
    }

    const confirmDeleteBtn = document.querySelector('#confirmDeleteBtn');
    confirmDeleteBtn.addEventListener('click', () => {
        deleteArticle()
            .then((data) => {
                const elements = document.querySelectorAll('.more');
                elements.forEach((el) => {
                    if ((el.getAttribute('data-id')) === data.id) {
                        el.parentNode.parentNode.parentNode.remove();
                    }
                });
                const fullArticle = document.querySelector('#full-article');
                fullArticle.querySelector('#title').textContent = '';
                fullArticle.querySelector('#content').textContent = '';
                fullArticle.classList.add('d-none');
            });
    })
});

