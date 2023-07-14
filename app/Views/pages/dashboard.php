<div class="mt-4 ">
    <h1>Dashboard</h1>
    <div class="col-sm-12 row" style="column-gap: 10px;">
        <div style="background-color: #17594A" class="card col-sm-6 col-md-3">
            <div style="justify-content: space-between; color: white; border-radius: 5px; display: flex;" class="card-body">
                <p>Jumlah Barang</p>
                <p><?= $tBarang ?></p>
            </div>
        </div>
        <div class="card col-sm-6 col-md-3 bg-info">
            <div style="justify-content: space-between; color: white; border-radius: 5px; display: flex;" class="card-body ">
                <p>Total Penjualan Selesai</p>
                <p><?= $tSelesai ?></p>
            </div>
        </div>
        <div class="card col-sm-8 col-md-3 bg-danger">
            <div style="justify-content: space-between; color: white; border-radius: 5px; display: flex;" class="card-body ">
                <p>Total Penjualan Batal</p>
                <p><?= $tBatal ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <h4>Grafik Penjualan bulan ini</h4>
        <canvas id="penjualan"></canvas>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data = <?= json_encode($data) ?>;
        console.log(data);
        var ctx = document.getElementById('penjualan');
        var labels = [];
        var selesai = [];
        var batal = [];
        Object.keys(data).forEach(key => {
            labels.push('Tanggal ' + key);
            batal.push(data[key]['batal']);
            selesai.push(data[key]['selesai']);
        })
        var dataset = {
            labels: labels,
            datasets: [{
                    label: 'Batal',
                    data: batal,
                    borderColor: '#F31559',
                    backgroundColor: '#EF6262',
                    yAxisID: 'y',
                    fill: false,
                },
                {
                    label: 'Selesai',
                    data: selesai,
                    borderColor: '#A2FF86',
                    backgroundColor: '#17594A',
                    yAxisID: 'y',
                    fill: false,
                }
            ]
        };
        var config = {
            type: 'line',
            data: dataset,
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                            type: 'linear',
                            display: true,
                            position: 'left',
                            id: 'y',
                        },

                    ]
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Line Chart'
                    }
                }
            },
        };
        console.log(dataset);
        new Chart(ctx, config);
    });
</script>