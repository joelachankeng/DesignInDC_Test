<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Joel Achankeng - Design In DC Test</title>

    <link rel="stylesheet" type="text/css" href="./dist/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <main>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
                        <title>Bootstrap</title>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
                    </svg>
                    <span class="fs-4">Joel Achankeng - Design In DC Test</span>
                </a>
            </header>

            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold" id="page-title">
                        All Games of <?php echo date("Y", strtotime("-1 year")); ?>
                    </h1>
                    <button type="button" id="view-all-btn" class="btn btn-success d-none">View All Games</button>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover mt-4" id="games-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Teams</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Arena</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="loading-row">
                                    <th scope="row" colspan="6">
                                        <div class="d-flex flex-column gap-3 align-items-center gap justify-content-center p-5 cursor-pointer">
                                            <div class="spinner-border" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <p>Loading results... Please wait</p>
                                        </div>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav class="d-none" aria-label="Teams pagination navigation" id="pagination">
                        <ul class="pagination justify-content-center">
                        </ul>
                    </nav>
                </div>
            </div>

            <footer class="pt-3 mt-4 text-body-secondary border-top">
                Joel Achankeng © <?php echo date("Y"); ?>
            </footer>
        </div>
        <div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="modal-error-Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-error-Title">Error</h5>
                    </div>
                    <div class="modal-body">
                        <p>There was issue loading the data. Please try again later.</p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="./dist/js/scripts.js"></script>

</body>

</html>