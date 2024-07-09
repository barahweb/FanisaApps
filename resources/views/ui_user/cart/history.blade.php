@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transaction History</li>
        </ol>
    </div>
</section>
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <div class="slider-inner">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <table class="table" style=" table-layout:fixed;">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Order</th>
                                    <th scope="col">Tanggal Order</th>
                                    <th scope="col">Ekspedisi</th>
                                    <th scope="col">Resi</th>
                                    <th scope="col">Ongkir</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Cara Bayar</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach ($histories as $history)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td><a href="/transaction-history/{{ $history->id_order }}">{{ $history->id_order
                                            }}</a>
                                    </td>
                                    <td>{{ $history->updated_at }}</td>
                                    <td> {{ $history->ekspedisi }}</td>
                                    <td> {{ $history->nomor_resi }}</td>
                                    <td>Rp
                                        {{ number_format($history->ongkir, 0, ',', '.') }}</td>
                                    <div style="display: none">
                                        {{ $total = 0 }}
                                    </div>
                                    @foreach ($history->order as $order)
                                    <div style="display: none">
                                        {{ $total += $order->harga * $order->quantity + $history->ongkir }}</div>
                                    @endforeach
                                    <td> Rp
                                        {{ number_format($total, 0, ',', '.') }}
                                    </td>
                                    @if($history->status == 2)
                                    <td> <a href="{{ $history->pdf }}" class="badge badge-primary">Cara Bayar</a>
                                    </td>
                                    @else
                                    <td> -
                                    </td>
                                    @endif
                                    @if ($history->status == 2)
                                    <td class="badge badge-warning mt-3" style="color: white">Menunggu<br>Pembayaran
                                    </td>
                                    @elseif ($history->status == 3)
                                    <td class="badge badge-success mt-3">Berhasil Bayar</td>
                                    @elseif ($history->status == 4)
                                    <td class="badge badge-primary mt-3"><a data-toggle='modal' style="color: white"
                                            href='#edit{{ $history->id_order }}' style="">
                                            Konfirmasi<br> Pemesanan</a></td>
                                    @elseif ($history->status == 5)
                                    <td class="badge badge-success mt-3">Transaksi<br> Selesai</td>
                                    @else
                                    <td class="badge badge-success mt-3">Batal</td>
                                    @endif
                                </tr>
                                <div class="modal fade" id="edit{{ $history->id_order }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><b>Konfirmasi</b> </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <form method="post" action="/finishOrder">
                                                @csrf
                                                <input type="hidden" name="id_order" value="{{ $history->id_order }}">
                                                <div class="col-sm-12 mt-3">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <div class="modal-body">
                                                                <p>Apakah anda yakin ingin mengubah status menjadi
                                                                    <b>"Selesai"</b> ?
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="button" class="btn btn-outline-danger"
                                                        data-dismiss="modal">Batal</button> --}}
                                                    {{-- <a href="" class="btn btn-outline-warning">Retur</a> --}}
                                                    <button type="submit"
                                                        class="btn btn-outline-success">Selesai</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</section>
@endsection