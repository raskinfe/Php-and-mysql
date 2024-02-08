<?php

$title = "New Offer";

require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';
require_once$_SERVER['DOCUMENT_ROOT'].'/services/helper.php';

?>

<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
<div class="container">
    <main>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/views/layouts/alert.php'; ?>
        <div class="form-container">
            <header class="__text">
                <h3>create new offer</h3>
            </header>
            <form action="#" onsubmit="storeOffer(); return false;" id="form">
                <div class="form-items-input">
                    <input type="file" name="image" placeholder="Image" id="image">
                </div>
                <div class="form-items-input">
                    <input type="text" name="title" placeholder="Title" id="title" required>
                </div>
                <div class="form-items-input">
                    <input type="text" id="author" placeholder="Author" name="author" required>
                </div>
                <div class="form-items-input">
                    <input type="number" id="isbn" placeholder="ISBN" name="isbn" required>
                </div>
                <div class="form-items-input">
                    <input type="date" id="published_year" placeholder="Published Year" name="published_year" required>
                </div>
                <div>
                    <select name="category" id="category" class="form-items-input" >
                        <option value="">Choose category</option>
                        <?php foreach (CATEGORIES as $key => $category): ?>
                            <option value="<?= $key ?>"><?= $category ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </main>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
<script>
    let file;
    const fileInput = document.getElementById('image');
    fileInput.onchange = (event) => {
        file = event.target.files;
        console.log(file);
    }

    const storeOffer = async() => {
        const formData = new FormData();
        const form = new FormData(document.getElementById('form'));
        const myHeaders = new Headers();
        myHeaders.append("Cookie", "PHPSESSID=626d15a10ce94228881f1ed189d37768");

        formData.append('title', form.get('title'));
        formData.append('author', form.get('author'));
        formData.append('isbn', form.get('isbn'));
        formData.append('published_year', form?.get('published_year'));
        formData.append('category', form?.get('category'));
        if (file) {
            formData.append('image', file[0]);
        }
        const response = await fetch('/save-offer', {body: formData, method: 'post', headers: myHeaders});
        if (response.status === 204) { document.getElementById('success').innerText = "Successfully created";
            setTimeout(()=> {
                window.location.href = '/';
            }, 2000)
           
        } else {
            document.getElementById('error').innerText = "Something went wrong please try again";
            setTimeout(()=> { window.location.reload(); }, 2000)
        }
    }
</script>
</body>
