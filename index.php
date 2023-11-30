<?php



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板アプリケーション</title>
  <link rel="stylesheet" href="./style.css">
</head>

<body>
  <h1 class="title">掲示板アプリ</h1>
  <hr>
  <div class="boardWrapper">

    <section>
      <article>
        <div class="wrapper">
          <div class="nameArea">
            <span>名前：</span>
            <p class="username">shincode</p>
            <time>2023/11/30</time>
          </div>
          <p class="comment">手書きコメントです</p>
        </div>
      </article>
    </section>

    <form class="formWrapper" method="post">
      <div>
        <input type="submit" value="書き込む">
        <label for="">名前：</label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea"></textarea>
      </div>
    </form>


  </div>
</body>

</html>