const editName = () => {
    document.getElementById('name').style.display ="none";
    document.getElementById('name-input').style.display ="block";
}

const updateName = async () => {
    const name = document.getElementById('--name').value;
    const myHeaders = new Headers();
    myHeaders.append("Cookie", "PHPSESSID=626d15a10ce94228881f1ed189d37768");

    const response = await sendRequest('/update-profile', 'post', {'name': name}, myHeaders)
    if (response.status === 204) {
        flashSuccess("Successfully updated");
    } else {
        flashErrors( "Update not successful");
    }
}

const destroyUser = async () => {
    const response = await fetch('/delete-profile', {
        method: 'delete',
    });
    if (response.status === 204) {
        document.getElementById('success').innerText = "Successfully deleted";
        setTimeout(()=> {
            document.getElementById('logout').click();
        }, 2000)
    } else {
        flashErrors("Delete not successful");
    }
}

let file;
const updateAvatar = (id) => {
    document.getElementById('avatar').click();

}

const fileInput = document.getElementById('avatar');
fileInput.onchange =  async (event) => {
    file = event.target.files;
    file = file[0];

    const users = getUser();
    const user = await (await getUserName(users[users.length - 1])).json();
    id = user.response?.id;
    if (file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('id', id);
        const resp = await fetch('/update-avatar', {body: formData, method: 'post'});
        if (resp.status === 204) {
            flashSuccess('updated successfully');
            window.location.reload();
            return;
        }
    }

    flashErrors('Update was not successful');
}

const getOffers = async () => {
  try {
    const response =  await fetch('/user-offers');
    if (response.status) {
        return response.json()
    }
    return Promise.reject(response);
  } catch (error) {
    return error.message;
  }
}

const offers = getOffers();
offers.then((offer) => {
    if (offer) {
        createOfferElement(offer.response)
    }
});

const createOfferElement = async (resp=[]) => {
    const parent = document.getElementById('offer-container');

    if (!resp?.length) {
        const offers = await getOffers()
        if (!offers) {
            return
        }
        const offersJson  = await offers;
        resp = offersJson.response;
    }

    if (!resp?.length) {
        return;
    }

    resp.map((offer) => {
        const child = document.createElement('div');
        child.setAttribute('class', 'offer');
        child.innerHTML = `
            <span>${offer.title}</span>
            <span>${offer.author}</span>
            <span>${offer.isbn}</span>
            <div class="--action">
                <a href="/edit-book?id=${offer.id}"><i class="fa fa-edit"></i></a>
                <i class="fa fa-trash" onclick="deleteOffer(${offer.id})"></i>
            </div>
        `;
        parent.appendChild(child);
    });

    parent.style.display = 'flex';
}

const deleteOffer = async (id) => {
    const myHeaders = new Headers();
    myHeaders.append("Cookie", "PHPSESSID=626d15a10ce94228881f1ed189d37768");
    const path = `/delete-book?id=${id}`;
    try {
        const post = await sendRequest(path, 'delete');
        if (post.status === 204) {
            flashSuccess('Successfully updated');
        } else {
            flashErrors('Delete was not successful');
        }
    } catch (error) {
        flashErrors(error.message);
    }
}

