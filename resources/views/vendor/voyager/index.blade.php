@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="analytics-container">
            <div class="row" style="color: white;">
                <div class="col-md-3">
                    <div class="card text-center" style="background-color: #967ad3;">
                        <h3>Prediksi Harga Alpukat</h3>
                        <h2 style="margin-bottom: 20px;" id="prediksi">
                            -
                        </h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" style="background-color: #F2435C;">
                        <h3>Biaya</h3>
                        <h2 style="margin-bottom: 20px;" id="biaya">
                            -
                        </h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" style="background-color: #42D07E;">
                        <h3>Omset</h3>
                        <h2 style="margin-bottom: 20px;" id="omset">
                            -
                        </h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center" style="background-color: #37AFF0;">
                        <h3>Profit</h3>
                        <h2 style="margin-bottom: 20px;" id="profit">
                            -
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <b>Hasil prediksi diatas (memakai prophet algoritm linear regression), menggunakan data penjualan dari tahun 2015 hingga 25 maret tahun 2018. Maka prediksi tersebut untuk tanggal 26 maret 2018</b>
                    </div>
                </div>
            </div>


            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $.ajax({
                url: "/api/dashboard",
                type: "GET"
            }).then(function (response) {
                let prediction = formatRupiah(response.prediction, 'Rp. ') + '/Kg';
                let cost = formatRupiah(response.cost, 'Rp. ');
                let revenue = formatRupiah(response.revenue, 'Rp. ');
                let profit = formatRupiah(response.profit, 'Rp. ');
                $('#prediksi').html(prediction);
                $('#biaya').html(cost);
                $('#omset').html(revenue);
                $('#profit').html(profit);
            }).fail(function (err) {
            });
        });
        function formatRupiah(angka, prefix){
            let number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            let minus = '';
            if(angka < 0){
                minus = '-';
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + minus + rupiah : '');
        }
    </script>
@stop
