<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FANISA - Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/print.css">
    <!-- endinject -->
    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>

    <link rel="icon" href="/assets/img/WK-logo.png">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css"
        href="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.css" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('admin.dashboard.layouts.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('admin.dashboard.layouts.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('container')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('admin.dashboard.layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="/vendors/chart.js/Chart.min.js"></script>
    <script src="/vendors/datatables.net/jquery.dataTables.js"></script>

    <script src="/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->

    <script src="/js/off-canvas.js"></script>
    <script src="/js/hoverable-collapse.js"></script>
    <script src="/js/template.js"></script>

    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="/js/dashboard.js"></script>
    <script src="/js/data-table.js"></script>
    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/jquery.dataTables.js"></script>
    {{-- Batas Select2 --}}
    <script src="/js/dataTables.bootstrap4.js"></script>
    {{-- <script src="/js/chart.js"></script> --}}
    <!-- End custom js for this page-->
    <script src="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.js"></script>
    <script src="/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="/js/my.js" type="text/javascript"></script>
    {{-- Cara Pakai Select 2 --}}

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });

    </script>
    <style>
        .custom-file-container__image-multi-preview {
            height: 300px;
        }
    </style>
    {{-- Selesai Pakai Select 2 --}}
    <script>
        $(document).on('click', '.btn-hapus', function (e) {
            event.preventDefault();
            var form = $(this).closest("form");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Anda Akan Menghapus Data Ini!",
                icon: "warning",
                title: "Apakah Anda Yakin?",
                confirmButtonText: 'Delete',
                confirmButtonColor: '#32CD32',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })

    </script>

    <script>
        var upload = new FileUploadWithPreview("myUniqueUploadId", {
            maxFileCount: 4,
            text: {
                chooseFile: "Pilih Gambar..",
                browse: "Browse",
            },
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn-update').click(function () {
                let idOrder = $(this).data('id')
                $('#editResi').modal('show')
                $('#idOrderUpd').val(idOrder)
            })
            $(document).on('click', '.updateResi', function (e) {
                event.preventDefault();
                let idOrder = $('#idOrderUpd').val()
                var form = $(this).closest("form");
                let no_resi = $('#nomor_resi').val()
                $.ajax({
                    method: "POST",
                    url: "/transaksi-penjualan/cekResi",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        idOrder,
                        no_resi,
                    },
                    dataType: "json",
                    success: function (response) {

                        if (response.hasil) {
                            $('#nomor_resi').addClass('is-invalid');
                            error_resi = 'Nomor Resi Sudah Ada';
                            $('.error_resi').text(error_resi);
                        } else if (no_resi == '') {
                            $('#nomor_resi').addClass('is-invalid');
                            error_resi = 'Nomor Resi Harus Diisi';
                            $('.error_resi').text(error_resi);
                        } else {
                            $('#error_resi').removeClass('is-invalid');
                            $('#error_resi').text('');
                            form.submit();
                        }
                    }
                })
            });
        })

    </script>

    <script>
        $(document).ready(function () {
            let id_product = $("#id_product").val()
            // console.log(id_product)

            $.ajax({
                method: "POST",
                url: "/ambilGambar",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id_product
                },
                dataType: "json",
                success: function (response) {
                    if (response.hasil) {
                        window.addEventListener("fileUploadWithPreview:imageDeleted", function (e) {
                            let arr = []
                            e.detail.cachedFileArray.forEach(function (item) {
                                arr.push(item.name)
                            })
                            console.log(arr)
                            arr = arr.map(i => 'post-images/' + i)
                            let join = arr.join('|')
                            let oldImage = document.getElementById("oldImage").value = join
                            console.log(oldImage)
                            // console.log(e.detail.cachedFileArray)
                            // console.log(e.detail.currentFileCount)
                        });
                        window.addEventListener("fileUploadWithPreview:imagesAdded", function (e) {
                            let arr = []
                            e.detail.cachedFileArray.forEach(function (item) {
                                arr.push(item.name)
                            })
                            console.log(arr)
                            arr = arr.map(i => 'post-images/' + i)
                            let join = arr.join('|')
                            let gambarBaru = document.getElementById("gambarBaru").value =
                                join
                            console.log(gambarBaru)
                            // console.log(e.detail.cachedFileArray)
                            // console.log(e.detail.addedFilesCount)
                        });
                        const arrs = response.gambar.gambar.split("|")
                        arr = arrs.map(i => '/storage/' + i);

                        var upload = new FileUploadWithPreview("myUniqueUploadId2", {

                            maxFileCount: 4,
                            text: {
                                chooseFile: "Pilih Gambar..",
                                browse: "Browse",
                            },
                            presetFiles: arr
                        });
                    }
                }
            });
        });

    </script>

    {{-- <script type="text/javascript">
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        var areaData = {
            labels: ["7 hari lalu", "6 hari lalu", "5 hari lalu", "4 hari lalu", "3 hari lalu", "2 hari lalu",
                "1 hari lalu"
            ],
            datasets: [{
                label: 'Pendapatan',
                data: [{{ pendapatanHariTujuh()->pendapatan }}, {{ pendapatanHariEnam()->pendapatan }},
                    {{ pendapatanHariLima()->pendapatan }}, {{ pendapatanHariEmpat()->pendapatan }}, {{ pendapatanHariTiga()->pendapatan }},
                    {{ pendapatanHariDua()->pendapatan }}, {{ pendapatanHariSatu()-> pendapatan }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
            }]
        };
        var areaChart = new Chart(areaChartCanvas, {
            type: 'line',
            data: areaData,
            options: {
                tooltips: {
                    mode: 'label',
                    bodySpacing: 10,
                    cornerRadius: 0,
                    titleMarginBottom: 15,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            let label = data.labels[tooltipItem.index];
                            let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = value.join('.');
                            return 'Rp ' + value;
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {}
                    }],
                    yAxes: [{
                        ticks: {
                            userCallback: function (value, index, values) {
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);
                                value = value.join('.');
                                return 'Rp ' + value;
                            }
                        }
                    }]
                },
            }
        });

    </script> --}}
    <script>
        $(document).ready(function () {
            $(document).on('click', '.simpanPembelian', function (e) {
                event.preventDefault();
                let no_faktur = $("#no_faktur").val()
                var form = $(this).closest("form");
                console.log(form)
                // console.log(no_faktur);
                $.ajax({
                    method: "POST",
                    url: "/transaksi-pembelian/cekFaktur",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        no_faktur,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.hasil) {
                            $('#no_faktur').addClass('is-invalid');
                            error_faktur = 'Nomor Faktur Sudah Ada';
                            $('.error_faktur').text(error_faktur);
                        } else {
                            $('#no_faktur').removeClass('is-invalid');
                            $('#no_faktur').text('');
                            form.submit();
                        }
                    }
                })
            });
        });

    </script>
    {{-- @include('sweetalert::alert') --}}
    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>
    @if (Session::has('status'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            }, 
            icon: "{{ session('status_icon') }}",
            title: "{{ session('status') }}",
            // text: "{{ session('status_text') }}",
            timer: 1500,
            timerProgressBar: true,
            showConfirmButton: false,
        })

    </script>
    @endif

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });

    </script>


</body>

</html>