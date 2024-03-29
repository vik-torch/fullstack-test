<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    
    <!-- JQuery 3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Select2 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    
    <!-- Компилированные JS от Bootstrap 4  -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <!-- Custom -->
    <script src="/scripts/comments.js"></script>
    
</head>
<body>
    <div class="container mt-3">
        <h1 class="mb-4">Comment Page</h1>

        <!-- Sort -->
        <div id="comments_sort">
            <div class="dropdown d-flex justify-content-end">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Выберите сортировку
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="javascript:void(0);" data-name="id" data-sort="ASC">По id комментария <i class="bi bi-sort-numeric-up-alt"></i></a>
                    <a class="dropdown-item" href="javascript:void(0);" data-name="id" data-sort="DESC">По id комментария <i class="bi bi-sort-numeric-down"></i></a>
                    <a class="dropdown-item active" href="javascript:void(0);" data-name="date" data-sort="ASC">По дате <i class="bi bi-sort-numeric-up-alt"></i></a>
                    <a class="dropdown-item" href="javascript:void(0);" data-name="date" data-sort="DESC">По дате <i class="bi bi-sort-numeric-down"></i></a>
                </div>
            </div>
        </div>
        <!-- Sort End -->

        <div id="comments_list" class="comments_list__wr my-5"></div>

        <!-- Pagination -->
        <nav id="comment_pagination" aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
            </ul>
        </nav>
        <!-- Pagination End -->

        <!-- Comment form -->
        <div class="comments_form__wr my-4">
            <h3 class="mb-4">Оставить коментарий</h3>
            <form id="comment_form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                </div>
                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea class="form-control" id="text" rows="3" placeholder="Any text" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        <!-- Comment form End -->

    </div>

    <!-- Comment pattern -->
    <div id="card_pattern" class="d-none">
        <div class="comment-card mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="email"></div>
                    <a class="ml-auto" href="javascript:void(0);">
                        <i class="bi bi-trash delete_btn"></i>
                    <a>
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                        <footer class="date">Someone famous in </footer>
                    </div>
                </div>
            </div>
            <div class="delete_button"></div>
        </div>
    </div>
    <!-- Comment pattern End -->
</body>
</html>