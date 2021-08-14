<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <div class="row articles">

    </div>

    <div class="row mt-3 d-none" id="full-article">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="title"></h5>
                    <p class="card-text" id="content"></p>
                </div>
            </div>
        </div>
    </div>

    <form class="mt-3">
        <div class="mb-3">
            <label for="title" class="form-label">Article title</label>
            <input type="text" class="form-control title" id="title" name="title">
            <div class="alert alert-danger mt-2 d-none" id="title-error" role="alert"></div>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Article content</label>
            <textarea type="text" class="form-control content" id="content" rows="3" name="content"></textarea>
            <div class="alert alert-danger mt-2 d-none" id="content-error" role="alert"></div>
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
    </form>

</div>

<!-- Modal -->
<div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="modalForm">
                    <input type="hidden" id="id-update">
                    <div class="mb-3">
                        <label for="title" class="form-label">Article title</label>
                        <input type="text" class="form-control" id="title-update">
                        <div class="alert alert-danger mt-2 d-none" id="title-error" role="alert">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Article content</label>
                        <textarea class="form-control" id="content-update" rows="3"></textarea>
                        <div class="alert alert-danger mt-2 d-none" id="content-error" role="alert">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deleting article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" id="delete-id">
            <div class="modal-body">
                <p>Are you sure you want to delete article - <span id="delete-title"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" data-bs-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="js/app.js"></script>

</body>
</html>
