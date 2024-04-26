<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Bahan Bakar</title>
    <style>
        body {
            text-align: center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url(https://www.shell.co.id/in_id/business-customers/program-dealer-owned-dealer-operated/_jcr_content/pagePromo/image.img.960.jpeg/1706691974642/fulfill-your-dream-to-have-own-shell-gas-station.jpeg);
            background-size: cover;
            color: #fff;
            background-attachment: fixed;
        }

        #container {
            width: 40%;
            margin: 125px auto;
            background-color: rgba(255, 255, 0, 0.2);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            font-size: 28px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        select,
        input[type="number"] {
            width: calc(60% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: calc(100% - 20px);
            padding: 15px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        hr {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 20px 0;
        }

        .bukti-transaksi {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            color: #000;
        }

        @media screen and (max-width: 600px) {
            #container {
                width: 90%;
                margin: 20px auto;
            }

            h2 {
                font-size: 24px;
            }

            select,
            input[type="number"],
            button {
                width: 100%;
            }
        }

    </style>
</head>

<body>
    <div id="container">
        <img src="images/1.png" alt="Logo Shell" style="width: 50px; margin-top: -20px;">
        <img src="images/2.png" alt="Logo Shell" style="width: 80px; margin-top: -20px;">
        <img src="images/3.png" alt="Logo Shell" style="width: 80px; margin-top: -20px;">
        <img src="images/4.png" alt="Logo Shell" style="width: 90px; margin-top: -20px;">
        <h2>ShellBensin</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter:</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <label for="metode">Metode Pembayaran:</label>
            <select id="metode" name="metode">
                <option value="Tunai">Tunai</option>
                <option value="Non-Tunai">Non-Tunai</option>
            </select>
            <br><br>
            <button type="submit">Beli</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;

                public function __construct($jenis, $harga, $jumlah)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN tetap 10%
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }
            }

            class Beli extends Shell
            {
                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTransaksi($metode)
                {
                    $total = $this->hitungTotal();
                    echo "<div class='bukti-transaksi'>";
                    echo "<hr>"; // Garis putus-putus sebelum output
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda membeli bahan bakar minyak dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>";
                    echo "<p><strong>Total yang harus anda bayar:</strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "<p><strong>Metode Pembayaran:</strong> " . $metode . "</p>";
                    echo "<hr>"; // Garis putus-putus setelah output
                    echo "</div>";

                    // Tambahkan tombol untuk mencetak
                    echo "<button onclick='printTransaksi()'>Cetak Bukti Transaksi</button>";
                }
            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];
            $metode = $_POST["metode"];

            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah);
                $beli->buktiTransaksi($metode);
            } else {
                echo "<p style='text-align: center;'>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>

        <script>
            function printTransaksi() {
                window.print(); // Memanggil fungsi pencetakan bawaan browser
            }
        </script>
    </div>
</body>

</html>
