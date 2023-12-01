<?php

date_default_timezone_set("Asia/Tokyo");

// データベースの値を格納する配列を用意
$comment_array = array();
$error_messages = array();
$pdo = null;
$stmt = null;


// DB接続
try {
  $pdo = new PDO('mysql:host=localhost;dbname=bbs', 'root', 'root');
} catch (PDOException $e) { // PDO が発するエラーを表します
  // -> は $e 内のgetMessageメソッドを取り出す
  echo $e->getMessage();
}


// フォームを打ち込んだとき
if (!empty($_POST['submitBtn'])) {

  // 名前のチェック
  if (empty($_POST['username'])) {
    echo '名前が入力されていません。';
    $error_messages['username'] = '名前が入力されていません。';
  }
  // コメントのチェック
  if (empty($_POST['comment'])) {
    echo 'コメントが入力されていません。';
    $error_messages['comment'] = 'コメントが入力されていません。';
  }

  if (empty($error_messages)) {
    $postDate = date("Y-m-d H:i:s");

    try {
      // idはオートインクリメントで自動追加にされているので必要なし
      $stmt = $pdo->prepare("INSERT INTO `bbs-table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate)");
      //bindParamで実際に値を入れる
      $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR); // 文字列として認識してくれる
      $stmt->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);

      //DBへの追加を実行
      $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}


//DBからコメントデータを取得する
$spl = "SELECT `id`,`username`,`comment`,`postDate` FROM `bbs-table`";
$comment_array = $pdo->query($spl);


//DBの接続を閉じる
$pdo = null;


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
      <!-- htmlを配列の数だけ生成するforeach -->
      <?php foreach ($comment_array as $comment) : ?>
        <article>
          <div class="wrapper">
            <div class="nameArea">
              <span>名前：</span>
              <p class="username"><?php echo $comment['username'] ?></p>
              <time>：<?php echo $comment['postDate'] ?></time>
            </div>
            <p class="comment"><?php echo $comment['comment'] ?></p>
          </div>
        </article>
      <?php endforeach; ?>

    </section>

    <form class="formWrapper" method="post">
      <div>
        <input type="submit" value="書き込む" name="submitBtn">
        <label for="">名前：</label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea" name="comment"></textarea>
      </div>
    </form>


  </div>
</body>

</html>