<?php
    include_once 'functions/authentication.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - GMS</title>
    <meta name="description" content="Gym Membership System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark" style="background: var(--bs-accordion-active-color);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -32 576 576" width="1em" height="1em" fill="currentColor" class="text-success" style="font-size: 46px;">
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M173.2 0c-1.8 0-3.5 .7-4.8 2C138.5 32.3 120 74 120 120c0 26.2 6 50.9 16.6 73c-22 2.4-43.8 9.1-64.2 20.5C37.9 232.8 13.3 262.4 .4 296c-.7 1.7-.5 3.7 .5 5.2c2.2 3.7 7.4 4.3 10.6 1.3C64.2 254.3 158 245.1 205 324s-8.1 153.1-77.6 173.2c-4.2 1.2-6.3 5.9-4.1 9.6c1 1.6 2.6 2.7 4.5 3c36.5 5.9 75.2 .1 109.7-19.2c20.4-11.4 37.4-26.5 50.5-43.8c13.1 17.3 30.1 32.4 50.5 43.8c34.5 19.3 73.3 25.2 109.7 19.2c1.9-.3 3.5-1.4 4.5-3c2.2-3.7 .1-8.4-4.1-9.6C379.1 477.1 324 403 371 324s140.7-69.8 193.5-21.4c3.2 2.9 8.4 2.3 10.6-1.3c1-1.6 1.1-3.5 .5-5.2c-12.9-33.6-37.5-63.2-72.1-82.5c-20.4-11.4-42.2-18.1-64.2-20.5C450 170.9 456 146.2 456 120c0-46-18.5-87.7-48.4-118c-1.3-1.3-3-2-4.8-2c-5 0-8.4 5.2-6.7 9.9C421.7 80.5 385.6 176 288 176S154.3 80.5 179.9 9.9c1.7-4.7-1.6-9.9-6.7-9.9zM240 272a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM181.7 417.6c6.3-11.8 9.8-25.1 8.6-39.8c-19.5-18-34-41.4-41.2-67.8c-12.5-8.1-26.2-11.8-40-12.4c-9-.4-18.1 .6-27.1 2.7c7.8 57.1 38.7 106.8 82.9 139.4c6.8-6.7 12.6-14.1 16.8-22.1zM288 64c-28.8 0-56.3 5.9-81.2 16.5c2 8.3 5 16.2 9 23.5c6.8 12.4 16.7 23.1 30.1 30.3c13.3-4.1 27.5-6.3 42.2-6.3s28.8 2.2 42.2 6.3c13.4-7.2 23.3-17.9 30.1-30.3c4-7.3 7-15.2 9-23.5C344.3 69.9 316.8 64 288 64zM426.9 310c-7.2 26.4-21.7 49.7-41.2 67.8c-1.2 14.7 2.2 28.1 8.6 39.8c4.3 8 10 15.4 16.8 22.1c44.3-32.6 75.2-82.3 82.9-139.4c-9-2.2-18.1-3.1-27.1-2.7c-13.8 .6-27.5 4.4-40 12.4z"></path>
                        </svg></div>
                    <div class="sidebar-brand-text mx-3"><span>GMS</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="members.php"><i class="far fa-folder-open"></i><span>Manage Members</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="status.php"><i class="far fa-calendar-alt"></i><span>Member Status</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="staff.php"><i class="far fa-user"></i><span>Manage Staff</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php"><i class="fas fa-table"></i><span>Reports</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="logs.php"><i class="far fa-address-card"></i><span>Users Activity Logs</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="functions/logout.php"><i class="far fa-clock"></i><span>Logout</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content" class="mt-5">
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Staff Management</h3><button class="btn btn-primary btn-sm mx-1 my-1" type="button" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Add Staff</button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Members Lists</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Fullname</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Created At</th>
                                            <th class="text-center">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php include_once 'functions/views/staff.php' ?>
                                    </tbody>
                                    <tfoot>
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © GMS 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/add-staff.php" method="post">
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Username" name="username"><label class="form-label" for="floatingInput">Username</label></div>
                        <div class="form-floating mb-3"><input type="password" class="form-control" placeholder="Password" name="password"><label class="form-label" for="floatingInput">Password</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Fullname" name="fullname"><label class="form-label" for="floatingInput">Fullname</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Address" name="address"><label class="form-label" for="floatingInput">Address</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Phone" name="phone"><label class="form-label" for="floatingInput">Phone</label></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/update-staff.php" method="post">
                        <input type="hidden" name="id">
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Username" name="username"><label class="form-label" for="floatingInput">Username</label></div>
                        <div class="form-floating mb-3"><input type="password" class="form-control" placeholder="Password" name="password"><label class="form-label" for="floatingInput">Password</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Fullname" name="fullname"><label class="form-label" for="floatingInput">Fullname</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Address" name="address"><label class="form-label" for="floatingInput">Address</label></div>
                        <div class="form-floating mb-3"><input type="text" class="form-control" placeholder="Phone" name="phone"><label class="form-label" for="floatingInput">Phone</label></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="remove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Staff</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="functions/remove-staff.php" method="post">
                        <p>Are you sure you want to remove this staff?</p>
                        <input type="hidden" name="id">
                    </div>
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">No</button><button class="btn btn-danger" type="submit">Yes</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get('type');
        const message = urlParams.get('message');
        if (type == 'success') {
            swal("Success!", message, "success");
        } else if (type == 'error') {
            swal("Error!", message, "error");
        }
    </script>
    <script>
        $(document).ready(function() {
                        $('#dataTable').DataTable({
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary'
                    }
                ]
            });

            $('button[data-bs-target="#update"]').on('click', function() {
                var id = $(this).data('id');
                var fullname = $(this).data('fullname');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
                var username = $(this).data('username');

                console.log(id);
                $('input[name="id"]').val(id);
                $('input[name="fullname"]').val(fullname);
                $('input[name="address"]').val(address);
                $('input[name="phone"]').val(phone);
                $('input[name="username"]').val(username);
            });

            $('button[data-bs-target="#remove"]').on('click', function() {
                var id = $(this).data('id');
                console.log(id);
                $('input[name="id"]').val(id);
            });

        });
    </script>
</body>

</html>