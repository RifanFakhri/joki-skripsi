<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Tally | PELINDO Terminal Berlian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef3f9;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 100px;
            overflow-x: hidden;
        }

        .card-main {
            width: 430px;
            background: #fff;
            border-radius: 26px;
            padding: 32px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title {
            font-size: 22px;
            font-weight: 800;
            color: #0060ad;
            margin-bottom: 26px;
        }

        label {
            font-weight: 700;
            font-size: 14px;
            color: #004c84;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 16px !important;
            background: #E0E0E0 !important;
            border: none !important;
            height: 48px;
            font-size: 14px;
            padding-left: 14px;
            color: #fff;
        }

        .form-control::placeholder {
            color: white;
        }

        .form-control:focus {
            background: #E0E0E0 !important;
            color: #fff;
            box-shadow: none !important;
        }

        .input-group .form-control {
            border-radius: 16px 0 0 16px !important;
        }

        .input-group .btn-search {
            height: 48px;
            border-radius: 0 16px 16px 0 !important;
            display: flex;
            align-items: center;
            background: #E0E0E0;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 0 18px;
        }

        .data-box {
            display: none;
            background: #e8f5ff;
            border-left: 5px solid #23B4F0;
            margin-top: 12px;
            padding: 14px;
            border-radius: 16px;
            animation: slideDown .3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .radio-wrap {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
            margin: 10px 0 22px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit {
            width: 100%;
            background: #23B4F0;
            padding: 14px;
            border-radius: 18px;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            border: none;
        }

        .btn-submit:hover {
            opacity: .92;
        }

        .suggestion-box {
            position: absolute;
            background: white;
            width: 100%;
            max-height: 170px;
            overflow-y: auto;
            border-radius: 10px;
            border: 1px solid #dcdcdc;
            z-index: 9999;
            display: none;
        }

        .suggestion-box div {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 14px;
        }

        .suggestion-box div:hover {
            background: #e6f2ff;
        }

        .input-wrap {
            position: relative;
        }
    </style>
</head>

<body>

    @include('navbar')

    <div class="card-main">

        <h4 class="text-center title">Konfirmasi Data Tally Bongkar</h4>

        <form method="POST" action="{{ route('tally.submit') }}">
            @csrf

            <label>No Container</label>
            <div class="input-group mb-3">
                <input type="text" id="no_container" name="no_container" class="form-control"
                    placeholder="Contoh: INBU5091548" required>
                <button type="button" class="btn btn-search" id="btnCari">Cari</button>
            </div>

            <label>No Lambung</label>
            <div class="input-wrap mb-3">
                <input type="text" id="no_lambung" name="no_lambung" class="form-control"
                    placeholder="Contoh: TB-09" required>
                <div id="lambungList" class="suggestion-box"></div>
            </div>

            <!-- DATA RESULT -->
            <div id="dataContainer" class="data-box">
                <p><strong>Kapal:</strong> <span id="kapal"></span></p>
                <p><strong>Agen:</strong> <span id="agen"></span></p>
                <p><strong>Voyage:</strong> <span id="voyage"></span></p>
                <p><strong>Size:</strong> <span id="size"></span></p>
                <p><strong>Tipe:</strong> <span id="tipe"></span></p>
                <p><strong>Berat:</strong> <span id="berat"></span></p>
                <p><strong>Nopol:</strong> <span id="nopol_show"></span></p>
                <p><strong>Depo:</strong> <span id="depo"></span></p>
            </div>

            <hr>

            <label class="mb-2">Keterangan</label>

            <div class="radio-wrap">
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="keterangan" value="Kade Lossing">
                    <span>Kade Lossing</span>
                </label>

                <label class="form-check">
                    <input class="form-check-input" type="radio" name="keterangan" value="Dangerous Without Label">
                    <span>Dangerous Without Label</span>
                </label>

                <label class="form-check">
                    <input class="form-check-input" type="radio" name="keterangan" value="Damage ?">
                    <span>Damage ?</span>
                </label>

                <label class="form-check">
                    <input class="form-check-input" type="radio" name="keterangan" value="Seal Exist">
                    <span>Seal Exist</span>
                </label>

                <label class="form-check">
                    <input class="form-check-input" type="radio" name="keterangan" value="Print DC">
                    <span>Print DC</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">Konfirmasi</button>
        </form>
    </div>

    <script>
        // ===================== FETCH DATA BUTTON =====================
        document.getElementById('btnCari').addEventListener('click', function () {
            let noCtr = document.getElementById('no_container').value;
            let noLambung = document.getElementById('no_lambung').value;

            fetch(`/tally-get-data?no=${noCtr}&lambung=${noLambung}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "found") {
                        document.getElementById("dataContainer").style.display = "block";

                        document.getElementById("kapal").innerText = data.row.NM_KAPAL;
                        document.getElementById("agen").innerText = data.row.NM_AGEN;
                        document.getElementById("voyage").innerText = data.row.VOYAGE_NO;
                        document.getElementById("size").innerText = data.row.SIZE_CTR;
                        document.getElementById("tipe").innerText = data.row.TIPE_CTR;
                        document.getElementById("berat").innerText = data.row.BERAT_CTR;
                        document.getElementById("nopol_show").innerText = data.row.Nopol ?? "-";
                        document.getElementById("depo").innerText = data.row.Depo_Tujuan ?? "-";
                    } else {
                        alert("Data tidak ditemukan!");
                        document.getElementById("dataContainer").style.display = "none";
                    }
                });
        });

        // ===================== AUTO SUGGEST =====================
        function autoSuggest(inputId, boxId, route) {
            const input = document.getElementById(inputId);
            const box = document.getElementById(boxId);

            input.addEventListener("keyup", () => {
                let val = input.value;
                if (val.length < 2) { box.style.display = "none"; return; }

                fetch(`${route}?q=${val}`)
                    .then(res => res.json())
                    .then(data => {
                        box.innerHTML = "";
                        if (data.length > 0) {
                            box.style.display = "block";
                            data.forEach(item => {
                                let div = document.createElement("div");
                                div.textContent = item;
                                div.onclick = function () {
                                    input.value = item;
                                    box.style.display = "none";
                                }
                                box.appendChild(div);
                            });
                        } else box.style.display = "none";
                    });
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            autoSuggest("no_container", "ctrList", "/api/cari-container");
            autoSuggest("no_lambung", "lambungList", "/api/cari-lambung");
        });
    </script>

</body>

</html>
