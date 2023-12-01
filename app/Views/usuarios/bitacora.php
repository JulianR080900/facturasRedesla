<style>
    section {
            padding: 50px;
            max-width: 800px;
            margin: 30px auto;
            background: white;
            background: white;
            backdrop-filter: blur(10px);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            transition: transform 0.2s ease-in-out;
        }
</style>
<div class="content">
    <section>
        <h3 style="color:black">Bitácora de campo</h3>
        <hr>
        <textarea class="form-control" rows="20"><?= $bitacora["bitacora"] ?></textarea>
        <hr>
        <button onclick="self.close()" class="btn btn-block bg-<?= $_SESSION['red'] ?>"><i class="fa-solid fa-caret-left"></i> Regresar</button>
    </section>
</div>