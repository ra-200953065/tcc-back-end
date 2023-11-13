<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>API TCC</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body translate="no">

  <div class="container">
    <h1>Inspeções</h1>
    <hr>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Responsável</th>
          <th>E-mail</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inspections as $item) : ?>
          <?php
          $dateArr = explode('-', $item['date']);
          ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $dateArr[2] ?>/<?= $dateArr[1] ?>/<?= $dateArr[0] ?></td>
            <td><?= $item['time'] ?></td>
            <td><?= $item['user']['name'] ?></td>
            <td><?= $item['user']['email'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>