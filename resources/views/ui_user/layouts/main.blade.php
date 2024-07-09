<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>FANISA</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.css" rel="stylesheet">

    <!-- Jquery UI -->
    <link type="text/css" href="/assets/css/jquery-ui.css" rel="stylesheet">
    <link rel="icon" href="/assets/img/WK-logo.png">
    <!-- Argon CSS -->
    <link type="text/css" href="/assets/css/argon-design-system.min.css" rel="stylesheet">

    <!-- Main CSS-->
    <link type="text/css" href="/assets/css/style.css" rel="stylesheet">

    <!-- Optional Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yeOsiKPVkU9v2S9z">
    </script>


    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> --}}
</head>

<body>
    @include('ui_user.layouts.header')
    <!------------------------------------------
    SLIDER
    ------------------------------------------->
    @yield('container')
    @include('ui_user.layouts.footer')
    <!-- Core -->
    <script src="/assets/js/core/jquery.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/core/jquery-ui.min.js"></script>

    <!-- Optional plugins -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Argon JS -->
    <script src="/assets/js/argon-design-system.js"></script>
    <script src="/js/my.js" type="text/javascript"></script>
    <!-- Main JS-->
    <script src="/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"
        integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        jQuery.extend(jQuery.validator.messages, {
            required: "Field tidak boleh kosong.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Field hanya boleh diisi dengan angka.",
            digits: "Hanya boleh angka.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            accept: "Please enter a value with a valid extension.",
            maxlength: jQuery.validator.format("Maksimal {0} angka."),
            minlength: jQuery.validator.format("Mohon masukan {0} angka."),
            rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
            range: jQuery.validator.format("Please enter a value between {0} and {1}."),
            max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
            min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
        });

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[A-Z a-z /S]+$/g.test(value);
        }, "Tidak boleh angka");
    </script>
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
    <script>
        $(document).on('click', '.btn-hapus', function(e) {
            event.preventDefault();
            var form = $(this).closest("form");
            console.log(form)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Barang Akan Dihapus Dari Keranjang!",
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
        $(document).ready(function() {
            //ini ketika provinsi tujuan di klik maka akan eksekusi perintah yg kita mau
            //name select nama nya "provinve_id" kalian bisa sesuaikan dengan form select kalian
            $('select[name="province_id"]').on('change', function() {
                // var tbl = document.getElementById("tbl");
                $("#kodepos").val('');
                $("#kurir").val('');
                $("#layanan").val('');
                $('select[name="kota_id"]').on('change', function() {
                    // membuat variable namakotaku untyk mendapatkan atribut nama kota
                    var namakotaku = $("#kota_id option:selected").attr("namakota");
                    var kodepos = $("#kota_id option:selected").attr("kodepos");
                    // menampilkan hasil nama provinsi ke input id nama_provinsi
                    $("#nama_kota").val(namakotaku);
                    $("#kodepos").val(kodepos);
                });
                // membuat variable namaprovinsiku untyk mendapatkan atribut nama provinsi
                var namaprovinsiku = $("#province_id option:selected").attr("namaprovinsi");
                // menampilkan hasil nama provinsi ke input id nama_provinsi
                $("#nama_provinsi").val(namaprovinsiku);
                // kita buat variable provincedid untk menampung data id select province
                let provinceid = $(this).val();
                //kita cek jika id di dpatkan maka apa yg akan kita eksekusi
                if (provinceid) {
                    // jika di temukan id nya kita buat eksekusi ajax GET
                    jQuery.ajax({
                        // url yg di root yang kita buat tadi
                        url: "/kota/" + provinceid,
                        // aksion GET, karena kita mau mengambil data
                        type: 'GET',
                        // type data json
                        dataType: 'json',
                        // jika data berhasil di dapat maka kita mau apain nih
                        success: function(data) {
                            // jika tidak ada select dr provinsi maka select kota kososng / empty
                            $('select[name="kota_id"]').empty();
                            optionText = '- Pilih Kabupaten -';
                            optionValue = '';
                            $('select[name="kota_id"]').append($(
                                '<option>').val(
                                optionValue).text(optionText));
                            // jika ada kita looping dengan each
                            $.each(data, function(key, value) {
                                // perhtikan dimana kita akan menampilkan data select nya, di sini saya memberi name select kota adalah kota_id
                                $('select[name="kota_id"]').append('<option value="' +
                                    value.city_id + ' " namakota="' + value.type +
                                    ' ' + value.city_name + '" kodepos="' + value
                                    .postal_code + '">' + value.type +
                                    ' ' + value.city_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="kota_id"]').empty();
                }
            });
        });
    </script>
    <script>
        $('select[name="kurir"]').on('change', function() {
            // kita buat variable untuk menampung data data dari  inputan
            // name city_origin di dapat dari input text name city_origin

            let origin = $("input[name=city_origin]").val();
            // name kota_id di dapat dari select text name kota_id
            let destination = $("select[name=kota_id]").val();
            // name kurir di dapat dari select text name kurir
            let courier = $("select[name=kurir]").val();
            // name weight di dapat dari select text name weight
            let weight = $("input[name=weight]").val();
            // alert(courier);
            if (courier) {
                jQuery.ajax({
                    url: "/origin=" + origin + "&destination=" + destination + "&weight=" + weight +
                        "&courier=" + courier,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="layanan"]').empty();
                        // ini untuk looping data result nya
                        $.each(data, function(key, value) {
                            // ini looping data layanan misal jne reg, jne oke, jne yes
                            optionText = '- Pilih Layanan -';
                            optionValue = '';
                            $('select[name="layanan"]').append($(
                                '<option>').val(
                                optionValue).text(optionText));
                            $.each(value.costs, function(key1, value1) {
                                $.each(value1.cost, function(key2, value2) {
                                    // console.log(value1.cost[0].etd);
                                    // console.log(courier)
                                    if(courier === 'pos'){
                                        let posIndo = value1.cost[0].etd.split(' ')
                                        // console.log(posIndo[0]) 
                                        $('select[name="layanan"]').append(
                                        '<option value="' + key +
                                        '" ongkir="' + value2
                                        .value + '"pilihLayanan="' + value1
                                        .description + ' - ' + value1.cost[0].etd + '">' +
                                        value1.description + ' - '+ value2.value + ' - ' 
                                        + posIndo[0] + ' HARI ' +
                                        '</option>');
                                    } else {
                                    $('select[name="layanan"]').append(
                                        '<option value="' + key +
                                        '" ongkir="' + value2
                                        .value + '"pilihLayanan="'  + value1
                                        .description + ' - ' + value1.cost[0].etd + ' HARI' + '">'  + value1.description + ' - ' + value2.value + ' - ' + value1.cost[0].etd + ' HARI' +
                                        '</option>');
                                    }
                                });
                                $('select[name="layanan"]').on('change', function() {
                                    var ongkir = $("#layanan option:selected")
                                        .attr("ongkir");
                                    var total_harga = document.getElementById(
                                        "subHarga").value
                                    var number_string = ongkir.toString(),
                                        sisa = number_string.length % 3,
                                        rupiah = number_string.substr(0, sisa),
                                        ribuan = number_string.substr(sisa)
                                        .match(/\d{3}/g);
                                    if (ribuan) {
                                        separator = sisa ? '.' : '';
                                        rupiah += separator + ribuan.join('.');
                                    }
                                    var row = document.getElementById("tbl")
                                        .rows;
                                    var r = document.getElementById("row").value
                                    var c = document.getElementById("col").value
                                    var Rp = document.getElementById("rp").value
                                    var r2 = document.getElementById("row2")
                                        .value
                                    var col = row[r].cells;
                                    var col2 = row[r2].cells;
                                    // ------------------------------------------------------------------ //
                                    hasil_jumlah = parseFloat(
                                        total_harga) + parseFloat(ongkir);
                                    var number_string2 = hasil_jumlah
                                        .toString(),
                                        sisa2 = number_string2.length % 3,
                                        rupiah2 = number_string2.substr(0,
                                            sisa2),
                                        ribuan2 = number_string2.substr(sisa2)
                                        .match(/\d{3}/g);
                                    if (ribuan) {
                                        separator = sisa2 ? '.' : '';
                                        rupiah2 += separator + ribuan2.join(
                                            '.');
                                    }
                                    var pilihLayanan = $(
                                            "#layanan option:selected")
                                        .attr("pilihLayanan");
                                    $("#paketLayanan").val(pilihLayanan);
                                    $("#hargaTotal").val(hasil_jumlah);
                                    $("#hargaOngkir").val(ongkir);
                                    col2[c].innerHTML = Rp + rupiah2;
                                    col[c].innerHTML = Rp + rupiah;
                                });
                            });
                        });
                    }
                });
            } else {
                $('select[name="layanan"]').empty();
            }
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $("#payment-form").validate({
                rules: {
                    province_id: {
                        required: true
                    },
                    kota_id: {
                        required: true
                    },
                    alamat: {
                        required: true
                    },
                    nohp: {
                        required: true
                    },
                    kurir: {
                        required: true
                    },
                    layanan: {
                        required: true
                    },
                },
                errorElement: 'div',
                highlight: (element, errorClass, validClass) => {
                    $(element).addClass("is-invalid")
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                }
            });
            $('#pay-button').click(function(event) {
                // event.preventDefault();
                if ($('#payment-form').valid()) {
                    event.preventDefault();
                    var hargaOngkir = document.getElementById("hargaOngkir").value;
                    var id_order = document.getElementById("id_order").value;
                    var nohp = document.getElementById("nohp").value;
                    var alamat = document.getElementById("alamat").value;

                    $.ajax({
                        url: '/snapToken',
                        data: {
                            hargaOngkir: hargaOngkir,
                            id_order: id_order,
                            nohp: nohp,
                            alamat: alamat,
                        },
                        cache: false,
                        // dataType: "json",
                        success: function(data) {
                            //location = data;
                            console.log('token = ' + data);

                            var resultType = document.getElementById('result-type');
                            var resultData = document.getElementById('result-data');

                            function changeResult(type, data) {
                                $("#result-type").val(type);
                                $("#result-data").val(JSON.stringify(data));
                                //resultType.innerHTML = type;
                                //resultData.innerHTML = JSON.stringify(data);
                            }
                            snap.pay(data, {
                                onSuccess: function(result) {
                                    changeResult('success', result);
                                    console.log(result.status_message);
                                    console.log(result);
                                    $("#payment-form").submit();
                                },
                                onPending: function(result) {
                                    changeResult('pending', result);
                                    console.log(result.status_message);
                                    $("#payment-form").submit();
                                },
                                onError: function(result) {
                                    changeResult('error', result);
                                    console.log(result.status_message);
                                    // $("#payment-form").submit();
                                }
                            });
                        }
                    });
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            let jumlahTersedia = document.getElementById('jumlahTersedia').innerHTML;
            // console.log(jumlahTersedia);
            $('.increment-btn').click(function(e) {
                e.preventDefault();
                var incre_value = $(this).parents('.quantity').find('.qty-input').val();
                var value = parseInt(incre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value < jumlahTersedia) {
                    value++;
                    $(this).parents('.quantity').find('.qty-input').val(value);
                    // console.log(value);
                }
            });

            $('.decrement-btn').click(function(e) {
                e.preventDefault();
                var decre_value = $(this).parents('.quantity').find('.qty-input').val();
                var value = parseInt(decre_value, 10);
                value = isNaN(value) ? 0 : value;
                if (value > 1) {
                    value--;
                    $(this).parents('.quantity').find('.qty-input').val(value);
                    // console.log(value);
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.increment-btn2').click(function(e) {
                e.preventDefault();
                let product_id = $(this).closest(".cartpage").find('.product_id').val();
                let incre_value = $(this).parents('.quantity2').find('.qty-input2').val();
                let value = parseInt(incre_value, 10);
                value = isNaN(value) ? 0 : value;
                let data = {
                    '_token': $('input[name=_token]').val(),
                    'product_id': product_id,
                }
                $.ajax({
                    context: this,
                    url: '/checkStokCart',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        // console.log(response);
                        if (value <= response.data_barang) {
                            value++;
                            $.ajax({
                                context: this,
                                url: '/updateCart',
                                type: 'POST',
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    quantity: value,
                                    product_id: product_id,
                                },
                                success: function(response) {
                                    if (response.hasil) {
                                        $(this).parents('.quantity2').find('.qty-input2').val(value);
                                        $(this).closest(".cartpage").find(
                                            '.totalHargaUpdate').text(
                                            `Rp ${response.harga.toLocaleString('id-ID')}`
                                        );
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-right',
                                            iconColor: 'white',
                                            customClass: {
                                                popup: 'colored-toast'
                                            },
                                            icon: "success",
                                            title: "Jumlah Pesanan Berhasil Diubah!",
                                            // text: "{{ session('status_text') }}",
                                            timer: 1500,
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                        });
                                    } else {
                                        $(this).parents('.quantity2').find('.qty-input2').val(response.jumlah);
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-right',
                                            iconColor: 'white',
                                            customClass: {
                                                popup: 'colored-toast'
                                            },
                                            icon: "error",
                                            title: "Tidak dapat menambah jumlah pesanan lagi!",
                                            // text: "{{ session('status_text') }}",
                                            timer: 1500,
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                        });
                                    }
                                }
                            });
                            // console.log(value);
                        }
                    }
                });
            });

            $('.decrement-btn2').click(function(e) {
                e.preventDefault();
                let product_id = $(this).closest(".cartpage").find('.product_id').val();
                // console.log(product_id);
                let decre_value = $(this).parents('.quantity2').find('.qty-input2').val();
                let value = parseInt(decre_value, 10);
                value = isNaN(value) ? 0 : value;
                let data = {
                    '_token': $('input[name=_token]').val(),
                    'product_id': product_id,
                }
                $.ajax({
                    context: this,
                    url: '/checkStokCart',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (value > 1) {
                            value--;
                            $(this).parents('.quantity2').find('.qty-input2').val(value);
                            // console.log(value);
                            $.ajax({
                                context: this,
                                url: '/updateCart',
                                type: 'POST',
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    quantity: value,
                                    product_id: product_id,
                                },
                                success: function(response) {
                                    // console.log(response.jumlah);
                                    if (response.hasil) {
                                        $(this).closest(".cartpage").find(
                                            '.totalHargaUpdate').text(
                                            `Rp ${response.harga.toLocaleString('id-ID')}`
                                        );
                                        let merahStok = $(this).closest(".cartpage").find('#merahStok').remove();
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-right',
                                            iconColor: 'white',
                                            customClass: {
                                                popup: 'colored-toast'
                                            },
                                            icon: "success",
                                            title: "Jumlah Pesanan Berhasil Diubah!",
                                            // text: "{{ session('status_text') }}",
                                            timer: 1500,
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                        });
                                    } else {
                                        $(this).closest(".cartpage").find(
                                            '.totalHargaUpdate').text(
                                            `Rp ${response.harga.toLocaleString('id-ID')}`
                                        );
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-right',
                                            iconColor: 'white',
                                            customClass: {
                                                popup: 'colored-toast'
                                            },
                                            icon: "error",
                                            title: "Jumlah " +response.namaBarang+ " Melebihi Stok! Stok yang tersedia: " + response.jumlah,
                                            // text: "{{ session('status_text') }}",
                                            timer: 1500,
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="sort"]').on('change', function() {
                let e = document.getElementById("sort");
                let sort = e.options[e.selectedIndex].id;
                if(sort == 'recent'){
                    var url = new window.URL(document.location);
                    url.searchParams.set("sort", sort);
                    window.location.replace(url.toString())
                } else if(sort == 'price'){
                    console.log('price')
                    var url = new window.URL(document.location);
                    url.searchParams.set("sort", sort);
                    window.location.replace(url.toString())
                } else {
                    var url = new window.URL(document.location);
                    window.location.replace(url.pathname.toString())
                }
            });
        });
    </script>
    <style>
        .error {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
            box-sizing: border-box;
        }
    </style>
</body>

</html>