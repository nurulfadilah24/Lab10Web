<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.2);
        }
        .form-container h2 {
            margin-bottom: 15px;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background: #0275d8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #025aa5;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Form Mahasiswa</h2>
    <form action="#" method="post">
        <label for="nim">NIM</label>
        <input type="text" id="nim" name="nim">

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama">

        <label for="alamat">Alamat</label>
        <input type="text" id="alamat" name="alamat">

        <button type="submit">Kirim</button>
    </form>
</div>

</body>
</html>
