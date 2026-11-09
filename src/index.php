<?php

session_start();

$title = $author = $year = $pages = $genreInput = "";
// Initialize books in session if not set
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [
        ['id' => 1, 'title' => '1984', 'author' => 'George Orwell', 'genre' => 'Fiction', 'year' => 1949, 'pages' => 328],
        ['id' => 2, 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'genre' => 'Fiction', 'year' => 1925, 'pages' => 180],
        ['id' => 3, 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'genre' => 'History', 'year' => 2011, 'pages' => 443]
    ];
}

$books = &$_SESSION['books']; 
// Genres list
$genres = ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography', 'Technology'];

// Current year for validation
$current_year = date("Y");
// Errors array 
$errors = [];
// Submitted data array
$submittedData = [
    'title' => '',
    'author' => '',
    'year' => '',
    'pages' => '',
    'genre' => ''
];
$editBook = null;
// Function to sanitize input
function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// Handle Delete
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    $books = array_values(array_filter($books, function ($book) use ($deleteId) {
        return $book['id'] !== $deleteId;
    }));
    $_SESSION['success'] = "Book deleted successfully!";
    header("Location: index.php");
    exit;
}
// Handle Edit (load book into form)
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['edit_id'])) {
    $editId = (int) $_GET['edit_id'];
    foreach ($books as $book) {
        if ($book['id'] === $editId) {
            $editBook = $book;
            $submittedData = [
                'title' => $book['title'],
                'author' => $book['author'],
                'genre' => $book['genre'],
                'year' => $book['year'],
                'pages' => $book['pages'],
            ];
            break;
        }
    }
}
// Handle Update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_id'])) {
    $editId = (int) $_POST['edit_id'];

    $title = validateInput($_POST['title'] ?? '');
    $author = validateInput($_POST['author'] ?? '');
    $genre = validateInput($_POST['genre'] ?? '');
    $year = validateInput($_POST['year'] ?? '');
    $pages = validateInput($_POST['pages'] ?? '');

    $submittedData = ['title' => $title, 'author' => $author, 'genre' => $genre, 'year' => $year, 'pages' => $pages];

    // Keep editBook set so form stays in edit mode on error
    foreach ($books as $book) {
        if ($book['id'] === $editId) {
            $editBook = $book;
            break;
        }
    }

    // Validate title
    if (empty($title)) {
        $errors['title'] = "Title is required";
    } else {
        foreach ($books as $book) {
            if (strtolower($book['title']) == strtolower($title) && $book['id'] !== $editId) {
                $errors['title'] = "Title already exists";
                break;
            }
        }
        if (empty($errors['title'])) {
            if (strlen($title) < 3)
                $errors['title'] = "Title is too short";
            elseif (strlen($title) > 120)
                $errors['title'] = "Title cannot exceed 120 characters";
        }
    }

    if (empty($author))
        $errors['author'] = "Author is required";
    else {
        $name_parts = array_filter(explode(' ', $author));
        if (count($name_parts) < 2)
            $errors['author'] = "Author must include at least two words.";
    }

    if (empty($genre))
        $errors['genre'] = "Genre is required.";
    elseif (!in_array($genre, $genres))
        $errors['genre'] = "Invalid genre selected.";

    if (empty($year))
        $errors['year'] = "Year is required.";
    elseif (!is_numeric($year) || strlen($year) != 4)
        $errors['year'] = "Year must be a 4-digit number.";
    elseif ($year < 1000 || $year > $current_year)
        $errors['year'] = "Year must be between 1000 and $current_year.";

    if (empty($pages))
        $errors['pages'] = "Number of pages is required.";
    elseif (!filter_var($pages, FILTER_VALIDATE_INT) || $pages <= 0)
        $errors['pages'] = "Pages must be a positive integer.";

    if (empty($errors)) {
        foreach ($books as &$book) {
            if ($book['id'] === $editId) {
                $book['title'] = $title;
                $book['author'] = $author;
                $book['genre'] = $genre;
                $book['year'] = (int) $year;
                $book['pages'] = (int) $pages;
                break;
            }
        }
        unset($book);
        $_SESSION['success'] = "Book \"$title\" updated successfully!";
        header("Location: index.php");
        exit;
    }
}
// Handle Add
// The code that is executed when the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['delete_id']) && !isset($_POST['edit_id'])) {

    //  Get and sanitize input
    $title = validateInput($_POST['title'] ?? '');
    $author = validateInput($_POST['author'] ?? '');
    $genre = validateInput($_POST['genre'] ?? '');
    $year = validateInput($_POST['year'] ?? '');
    $pages = validateInput($_POST['pages'] ?? '');

    // Store submitted data for repopulating the form in case of errors
    $submittedData = [
        'title' => $title,
        'author' => $author,
        'genre' => $genre,
        'year' => $year,
        'pages' => $pages,
    ];
    //  Validate title
    if (empty($title)) {
        $errors['title'] = "Title is required";
    } else {
        // duplicate check
        foreach ($books as $book) {
            if (strtolower($book['title']) == strtolower($title)) {
                $errors['title'] = "Title already exists";
                break;
            }
        }

        // length check
        if (empty($errors['title'])) {
            if (strlen($title) < 3)
                $errors['title'] = "Title is too short";
            elseif (strlen($title) > 120)
                $errors['title'] = "Title cannot exceed 120 characters";
        }
    }

    //  Validate author
    if (empty($author)) {
        $errors['author'] = "Author is required";
    } else {
        $name_parts = array_filter(explode(' ', $author));
        if (count($name_parts) < 2)
            $errors['author'] = "Author must include at least two words.";
    }

    //  Validate genre
    if (empty($genre))
        $errors['genre'] = "Genre is required.";
    elseif (!in_array($genre, $genres))
        $errors['genre'] = "Invalid genre selected.";

    //  Validate year
    if (empty($year))
        $errors['year'] = "Year is required.";
    elseif (!is_numeric($year) || strlen($year) != 4)
        $errors['year'] = "Year must be a 4-digit number.";
    elseif ($year < 1000 || $year > $current_year)
        $errors['year'] = "Year must be between 1000 and $current_year.";

    // Validate pages
    if (empty($pages))
        $errors['pages'] = "Number of pages is required.";
    elseif (!filter_var($pages, FILTER_VALIDATE_INT) || $pages <= 0)
        $errors['pages'] = "Pages must be a positive integer.";

    // If no errors, process the data
    if (empty($errors)) {
        // ID generation
        $maxId = 0;
        foreach ($books as $book) {
            if ($book['id'] > $maxId)
                $maxId = $book['id'];
        }
        $newId = $maxId + 1;
        // Store submitted data in session
        $books[] = [
            'id' => $newId,
            'title' => $title,
            'author' => $author,
            'genre' => $genre,
            'year' => (int) $year,
            'pages' => (int) $pages,
        ];
        $_SESSION['success'] = "Book \"$title\" added successfully!";
        $submittedData = ['title' => '', 'author' => '', 'genre' => '', 'year' => '', 'pages' => ''];
        header("Location: index.php");
        exit;
    }
}
?>











<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Book Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

        <!-- Success Alert -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Error Alert -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                Please fix the errors below.
            </div>
        <?php endif; ?>



        <div class="row">

            <!-- Form (Left) -->
            <div class="col-md-4">
                <h3><?php echo $editBook ? 'Edit Book' : 'Add New Book'; ?></h3>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <?php if ($editBook): ?>
                        <input type="hidden" name="edit_id" value="<?php echo $editBook['id']; ?>">
                    <?php endif; ?>

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['title']) ? 'is-invalid' : ''; ?>" name="title"
                            value="<?php echo htmlspecialchars($submittedData['title']); ?>">
                        <?php if (isset($errors['title'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['title']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Author -->
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['author']) ? 'is-invalid' : ''; ?>"
                            name="author" value="<?php echo htmlspecialchars($submittedData['author']); ?>">
                        <?php if (isset($errors['author'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['author']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Genre -->
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <select class="form-select <?php echo isset($errors['genre']) ? 'is-invalid' : ''; ?>"
                            name="genre">
                            <option value="">Select Genre</option>
                            <?php foreach ($genres as $g): ?>
                                <option value="<?php echo $g; ?>" <?php echo ($g === $submittedData['genre']) ? 'selected' : ''; ?>>
                                    <?php echo $g; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['genre'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['genre']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Year -->
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['year']) ? 'is-invalid' : ''; ?>" name="year"
                            value="<?php echo htmlspecialchars($submittedData['year']); ?>">
                        <?php if (isset($errors['year'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['year']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Pages -->
                    <div class="mb-3">
                        <label class="form-label">Pages</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['pages']) ? 'is-invalid' : ''; ?>" name="pages"
                            value="<?php echo htmlspecialchars($submittedData['pages']); ?>">
                        <?php if (isset($errors['pages'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['pages']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">
                        <?php echo $editBook ? 'Update Book' : 'Add Book'; ?>
                    </button>
                    <?php if ($editBook): ?>
                        <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
                    <?php endif; ?>

                </form>
            </div>

            <!-- Table (Right) -->
            <div class="col-md-8">
                <h3>Book List</h3>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Pages</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $book['id']; ?></td>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['genre']); ?></td>
                                <td><?php echo (int) $book['year']; ?></td>
                                <td><?php echo $book['pages']; ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="index.php?edit_id=<?php echo $book['id']; ?>"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?php echo $book['id']; ?>">
                                        Delete
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $book['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete
                                                    <strong><?php echo htmlspecialchars($book['title']); ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST"
                                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                        <input type="hidden" name="delete_id"
                                                            value="<?php echo $book['id']; ?>">
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>