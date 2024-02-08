const getResults = () => {
    const items = getLocalStorage();
    document.getElementById('counter').innerText = items?.length || 0;
}

const getLocalStorage = () => {
    return JSON.parse(localStorage.getItem('orders'))
}

const setLocalStorage = (items) => {
    const now = new Date()
    localStorage.setItem('orders', JSON.stringify(items));
    localStorage.setItem('expiry', JSON.stringify(now.getTime()+ (20 * 60 * 1000)));
}

const sendRequest = async (url, requestMethod='GET', payload='', headers='') => {
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const requestOptions = {
        method: requestMethod,
        headers: myHeaders,
        redirect: 'follow'
    };

    if (payload) {
        const formData = new FormData();
        Object.keys(payload).forEach((key) => {
            if (key !== undefined) {
                formData.append(key, payload[key]);
            }
        })

        requestOptions.body = formData;
    }

    if (headers) {
        requestOptions.headers = headers;
    }

    return await fetch(url, requestOptions)
}

const isUserLoggedIn = (name) => {
    const user = getUser();
    return user.filter((userName) => userName === name).length
}

const getUserName = async (name) => {
    const myHeaders = new Headers();
    myHeaders.append("Cookie", "PHPSESSID=626d15a10ce94228881f1ed189d37768");
    try {
        return sendRequest('http://localhost:8080/user-name', 'POST', {'name': name}, myHeaders);
    } catch (e) {
        return null;
    }
}

const clearLocal = () => {
    window.localStorage.clear();
    window.location.href = '/logout';
}

let active = false
const showCart = () => {
    const parent = document.querySelector('.right-panel');
    removeCartItems();
    createCartItems();
    active = !active;
    parent.style.display = active ? 'flex' : 'none';
}

const createCartItems = () => {
    const parent = document.querySelector('.right-panel');
    const items = getLocalStorage();
    if (items?.length > 0) {
        items.forEach((item) => {
            const child = document.createElement('div');
            child.setAttribute('class', 'single-item');
            child.innerHTML = `
                <div class="--title">${item.title}</div>
                <div class="--isbn">${item.isbn}</div>
                <div class="--action" onclick="removeItem(${item.id})"><i class="fa fa-trash"></i></div>
            `;
            parent.appendChild(child);
        })
        const action = document.createElement('div');
        action.setAttribute('class', '--checkout');
        action.innerHTML = `<button class="btn btn-primary --checkout" onclick="" id="">
                                    <span> Checkout </span>
                                     <i class="fa fa-shopping-cart"></i>
                                </button>`;
        parent.appendChild(action)
    } else {
        const child = document.createElement('div');
        child.setAttribute('class', 'no-item');
        child.innerHTML = `<span>No items in cart</span>`;
        parent.appendChild(child);
    }
}

const removeCartItems = () => {
    document.querySelectorAll('.single-item').forEach((element) => element.remove());
    document.querySelectorAll('.no-item').forEach((element) => element.remove());
    document.querySelectorAll('.--checkout').forEach((element) => element.remove());
}


const now = new Date();
const expiry = JSON.parse(localStorage.getItem('expiry'));

if (now.getTime() > expiry) {
    localStorage.clear();
}

const flashSuccess = (message) => {
    document.getElementById('success').innerText = message;
    setTimeout(()=> { window.location.reload(); }, 2000);
}

const flashErrors = (message) => {
    document.getElementById('error').innerText = message;
    setTimeout(() => { window.location.reload(); }, 2000);
}

const getUser = () => {
    const user = [];
    document.cookie.split(';').forEach((cook) => {
        user.push(cook.split('=')[1].split("%20").join(" "));
    });
    return user;
}
