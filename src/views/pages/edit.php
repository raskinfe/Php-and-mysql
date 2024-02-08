<?php
use src\services\Connection;

$id = $_GET['id'];

if (!isset($id)) {
    header('/');
    exit();
}

$pdo = Connection::getPdo();

$sql = "SELECT coverimages.image, books.title, books.author, books.isbn
FROM coverimages
INNER JOIN books ON coverimages.book_isbn=books.isbn";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute(['id' => $id]);
    $book = $stmt->fetch();
} catch (PDOException $execption) {
    header('/');
    exit();
}
$title = "Edit";
require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/header.php';
require_once$_SERVER['DOCUMENT_ROOT'].'/views/layouts/includes.php';
?>

<?php if(isset($book)): ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/navigation.php';?>
    <div class="book-container">
    <?php include $_SERVER['DOCUMENT_ROOT'].'/views/layouts/alert.php'; ?>
        <div class="book-image">
            <img src="/assets/uploads/<?= $book["image"]?>" alt="cover-image"/>
            <input type="file" class="cover" id="<?= $book['isbn'] ?>" hidden/>
            <button class="btn btn-primary" onclick="updateCover()">
                <span>Change picture</span>
            </button>
        </div>
        <div class="form-control">
            <div class="form-group">
                <span class="label">Title</span>
                <input type="text" value="<?=$book['title']?>" name="title" id="title">
            </div>
            <div class="form-group">
                <span class="label">Author</span>
                <input type="text" value="<?=$book['author']?>" name="author" id="author">
            </div>
            <div class="form-group">
                <span class="label">ISBN</span>
                <input type="text" value="<?=$book['isbn']?>" name="isbn" id="isbn">
            </div>
            <button class="btn btn-primary" onclick="update(<?=$id?>)">
                <span>Update</span>
            </button>
        </div>
    </div>
    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/views/layouts/footer.php';?>
<?php endif ?>

<script>
    const update = async (id) => {
        const myHeaders = new Headers();
        myHeaders.append("Cookie", "PHPSESSID=626d15a10ce94228881f1ed189d37768");

        const title = document.querySelector("#title").value || '';
        const author = document.querySelector("#author").value || '';
        const isbn = document.querySelector("#isbn").value || '';
        const payload = {id, title, author, isbn};

        const resp = await sendRequest('/update-book', 'post', payload, myHeaders);
        if (resp.status === 204) {
            flashSuccess('Updated successfully');
            return ;
        }
        flashErrors('Something went wrong. Please try again');
    }

    let file;
    const fileInput = document.querySelector('.cover');
    fileInput.onchange = async (event) => {
        file = event.target.files;
        file = file[0];
        const isbn = document.querySelector('.cover').getAttribute('id');

        if (file) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('isbn', isbn);
            const resp = await fetch('/update-book-cover', {body: formData, method: 'post'});
            if (resp.status === 204) {
                flashSuccess('updated successfully');
                window.location.reload();
                return;
            }
        }
        flashErrors('Update was not successful');
    }

    const updateCover = async () => {
        document.querySelector('.cover').click()
    }

</script>
