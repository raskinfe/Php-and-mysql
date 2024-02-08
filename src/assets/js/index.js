let response;

const getBooks = async () => {
    return await sendRequest("http://localhost:8080/books");
}

response = getBooks();
response.then(async (result) => {
    const resp = await result.json()
    createElement(resp.response)
});

const filterCategory = async () => {
    const checked = [];
    document.querySelectorAll('.category').forEach((item) => {
        if (item.checked) {
            checked.push(item.value);
        }
    });

    if (!checked.length) {
        response = await (await getBooks()).json();
        createElement(response.response)
        return ;
    }
  
    try {
        const resp = await sendRequest("http://localhost:8080/books-category?categories="+checked);
        if (resp.status === 200) {
            response = await resp.json();
            createElement(response.response);
            return ;
        }
        createElement([]);
    } catch (error) {
        createElement([]);
    }

}

const createElement = (response) => {
    const parent = document.getElementById('offers');
    const orders = getLocalStorage();
    if (response.length === 0) {
        document.getElementById('hidden').style.display = "block";
        parent.style.display = 'none';
        return ;
    }
    document.querySelectorAll('.__single_offer').forEach((element) => element.remove())
    document.getElementById('hidden').style.display = "none";
    response.forEach(async (resp, index) => {
        const child = document.createElement('div');
        child.setAttribute('class', '__single_offer');
        const url = `./assets/uploads/${resp.image}`;
        child.innerHTML = `
                            <div class="__image">
                                <img src="${url}" >
                            </div>
                            <div class="__title" id="__title">Title: <span class="__text">${resp.title}</span></div>
                            <div class="__author" id="__author">Author: <span class="__text">${resp.author}</span></div>
                            <div class="__created_by" id="__created_by">Posted By: <span class="__text">${resp.name}</span></div>
                            <div class="__isbn" id="__isbn">ISBN: <span class="__text">${resp.isbn}</span></div>
                            <div class="__status" id="__status">Status: <span class="__text">${resp.status}</span></div>
                    `;
        const action =  document.createElement('div');
        action.setAttribute('class', '__action');

        if (resp.status === 'active' && !isUserLoggedIn(resp.name)) {
            const isOrderExist = orders?.filter((order) => order.id === resp.id);
            if (isOrderExist?.length) {
                action.innerHTML = `
                <button class="btn btn-secondary __action" onclick="removeItem(${isOrderExist[0].id})" id="${index}">
                        ${removeBtn()}
                </button>
            `;
            } else  {
                action.innerHTML = `
                <button class="btn btn-primary __action" onclick="addToCart(${resp.isbn}, '${resp.title}', ${index})" id="${index}">
                        ${addBtn()}
                </button>
            `;
            }
            child.appendChild(action)
        } else {
            action.innerHTML = `<a class="btn btn-third __action" href="/edit-book?id=${resp.id}" id="${index}">
                                    ${editBtn()}
                                </a>`;
            child.appendChild(action)
        }
        parent.appendChild(child);
        parent.style.display = 'flex'
    });
}

const addToCart = async (isbn, title, id) => {
    const element = document.getElementById(id);
    const item =  await (await getBooks()).json();
    const result = item.response.filter((res) => res.title === title && +res.isbn === isbn);
    let oldItems = getLocalStorage();
    if (!oldItems) {
        oldItems = [];
    }
    result[0].elementId = id;
    oldItems.push(result[0]);
    setLocalStorage(oldItems);
    removeCartItems();
    createCartItems();
    element.classList.remove('btn-primary');
    element.classList.add('btn-secondary');
    element.innerHTML = removeBtn();
    element.removeAttribute('onclick');
    element.setAttribute('onclick', `removeItem(${result[0].id}, ${id})`);

    getResults();
}

const removeItem = async (itemId) => {
    const oldItems = getLocalStorage();
    const thisItem = oldItems.filter((item) => +item.id === itemId);
    const id = thisItem[0].elementId;
    setLocalStorage(oldItems?.filter((item) => +item.id !== itemId) || []);
    removeCartItems();
    createCartItems();
    const element = document.getElementById(id);
    element.classList.remove('btn-secondary');
    element.classList.add('btn-primary');
    element.innerHTML = addBtn();
    element.removeAttribute('onclick');
    element.setAttribute('onclick', `addToCart(${thisItem[0].isbn}, '${thisItem[0].title}', ${id})`);
    getResults();
}

const addBtn = () => {
    return   `
                <span>Add to cart </span>
                <i class="fa fa-plus"></i>
            `;
}

const removeBtn = () => {
    return `<span>remove from cart </span>
            <i class="fa fa-trash"></i>`;
}

const editBtn = () => {
    return `<span>Edit offer </span>
            <i class="fa fa-edit"></i>`;
}
