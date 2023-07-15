<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
 <body>
        
        
        <?php
        //DBに接続
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //tableの追加
        $sql = "CREATE TABLE IF NOT EXISTS keijiban"
       ."("
       . "id INT AUTO_INCREMENT PRIMARY KEY,"
       . "name char(32),"
       . "comment TEXT,"
       . "date DATETIME,"
       . "password char(10)"
       .");";
        $stmt = $pdo-> query($sql);
        
        //全テーブル表示・確認
    /*    $sql = 'SHOW TABLES';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo $row[0];
            echo '<br>';
        }
        echo "<hr>"; */
        
        //変数に値を代入
            $DATE = date("Y年m月d日 H時i分s秒");
           // $filename = "mission_3-5.txt";
            
             //editnumに番号が入っていた時の処理
            if(!empty($_POST["editnum"])){
                $editnum = $_POST["editnum"];
                $name = $_POST["str"];
                $comment = $_POST["STR"];
             /*   $text = (file($filename, FILE_IGNORE_NEW_LINES));
                 $fp2 = fopen($filename, "w");
                foreach($text as $texts){
                    $row = explode("<>", $texts);
                    if($row[0] == $editnum && $row[4] == $PAS){ //編集番号と投稿番号が一致していた時の処理
                        fwrite($fp2, $editnum. "<>" . $str . "<>" . $STR . "<>" . $DATE . PHP_EOL);
                    }else{
                        fwrite($fp2, $texts . PHP_EOL);
                    }
                }
                fclose($fp2); */
                
                //データ内容を編集
              //  $name1 = "しょがすと";
              //  $comment1 = "しゃーーーーー";
                $sql = 'UPDATE keijiban SET name=:name, comment=:comment WHERE id=:id';
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $editnum, PDO::PARAM_INT);
                $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
                $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt -> execute();
                
               //データ抽出・表示
                 $sql = 'SELECT * FROM keijiban';
                 $stmt = $pdo -> query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     echo $row['id']. ",";
                     echo $row['name']. ",";
                     echo $row['comment']. ",";
                     echo $row['date']. ",";
                     echo $row['password']. "<br>";
                echo "<hr>";
                 } 
                
                
                //新規投稿の時の処理
            }elseif(!empty($_POST["str"]) && !empty($_POST["STR"])){ //条件式
                 $name = $_POST["str"];
                 $comment = $_POST["STR"];
                 $password = $_POST["password"];
                 
                 //tableにデータ入力
                 $sql = $pdo -> prepare("INSERT INTO keijiban (name, comment, date, password) VALUES (:name, :comment, now(), :password)");
                 $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                 $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                // $sql -> bindParam(':date', now(), PDO::PARAM_INT);
                 $sql -> bindParam('password', $password, PDO::PARAM_STR);
                 $sql -> execute();
                 
                 //データ抽出・表示
                 $sql = 'SELECT * FROM keijiban';
                 $stmt = $pdo -> query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     echo $row['id']. ",";
                     echo $row['name']. ",";
                     echo $row['comment']. ",";
                     echo $row['date']. ",";
                     echo $row['password']. "<br>";
                echo "<hr>";
                 } 
              /*  if(file_exists($filename)){
                    $num = file($filename, FILE_IGNORE_NEW_LINES);  //1行ずつ配列に代入
                    if(count($num) > 0){                           //投稿番号のカウントアップ
                        $NUMBERS = explode("<>", array_pop($num));
                        $id = $NUMBERS[0] + 1 ;
                }else{
                    $id = 1;
                  }
                }
                $line = $id. "<>" . $str . "<>" . $STR . "<>" . $DATE . "<>" . $PAS;
                $fp = fopen($filename, "a"); 
                fwrite($fp, $line . PHP_EOL);//ファイル追加書き込み
                fclose($fp); */
                
                //削除の時の処理
            }elseif(!empty($_POST["delete"])){ //条件式
                $delete = $_POST["delete"];
                $password1 = $_POST["Pass"];
               /* //ファイルの読み込み
                $LINES = (file($filename, FILE_IGNORE_NEW_LINES));
                 //ファイルを空に
               $fp1 = fopen($filename, "w"); 
                //<>で分割
                foreach($LINES as $word){
                    $words = (explode("<>", $word)); 
                //削除番号と投稿番号が一致しないときの処理
                    if($words[4] != $passed && $words[0] != $delete){
                //    $fp1 = fopen($filename, "w");
                        fwrite($fp1, $word . PHP_EOL);//ファイル書き込み
                    }elseif($words[4] == $passed && $words[0] == $delete){
                  //      fwrite($fp1, " " . PHP_EOL);
                    }
                        
                }
                fclose($fp1); */
                
                $sql = 'delete from keijiban WHERE id=:id AND password=:password';
                $stmt = $pdo ->prepare($sql);
                $stmt -> bindParam(':id', $delete, PDO::PARAM_INT);
                $stmt -> bindParam(':password', $password1, PDO::PARAM_STR);
                $stmt -> execute();
                
               //データ抽出・表示
                 $sql = 'SELECT * FROM keijiban';
                 $stmt = $pdo -> query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     echo $row['id']. ",";
                     echo $row['name']. ",";
                     echo $row['comment']. ",";
                     echo $row['date']. ",";
                     echo $row['password']. "<br>";
                echo "<hr>";
                 } 
                 
                //編集の時の処理
            }elseif(!empty($_POST["edit"])){ //条件式
                $edit = $_POST["edit"];
                $password2 = $_POST["pass"];
               // $editnum = $_POST["editnum"];
             /*  $sentence =(file($filename, FILE_IGNORE_NEW_LINES));
               foreach($sentence as $sent){
                   $sents = explode("<>", $sent);
                   if($sents[0] == $edit){  
                       $editname = $sents[1];  
                       $editcomment = $sents[2];
                       
                   }
               } */
                
                $sql = 'SELECT * FROM keijiban WHERE id=:id AND password=:password';//投稿番号と編集番号、パスワードが一致した時の処理
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id', $edit, PDO::PARAM_INT);
                $stmt -> bindParam(':password', $password2, PDO::PARAM_STR);
                $stmt -> execute();
                $results = $stmt->fetch(PDO::FETCH_NUM);
                $editname = $results[1];//対応番号の名前を取得
                $editcomment = $results[2];//対応番号のコメントを取得 
                
            }
           
           
                
            ?>
            
        <form action="" method="post">
            <!--名前-->
            <input type="text" name="str" placeholder="名前" value="<?php if(isset($editname)){echo $editname;}?>"> <br>
            <!--コメント-->
            <input type="text" name="STR" placeholder="コメント" value="<?php if(isset($editcomment)){ echo $editcomment; }?>">
            <input type="hidden" name="editnum" value="<?php if(isset($edit)){echo $edit;}?>"><br>
            <input type="text" name="password" placeholder="パスワード">
            <input type="submit" name="submit"><br>
            <!--削除-->
          <p><input type="number" name="delete" placeholder="削除対象番号"><br>
             <input type="text" name="Pass" placeholder="パスワード">
            <input type="submit" name="submit" value="削除"></p>
            <!--編集-->
           <p><input type="number" name="edit" placeholder="編集番号指定"><br>
           <input type="text" name="pass" placeholder="パスワード">
            <input type="submit" name="submit" value="編集"></p>
            
        </form>  
        
            
     
           <?php 
            /*if(file_exists($filename)){
                $line = (file($filename, FILE_IGNORE_NEW_LINES));
                foreach($line as $word){
                    echo $word;
                    echo "<br>";
                      }
            } */
            
            //データの抽出・表示
          /*       $sql = 'SELECT * FROM keijiban';
                 $stmt = $pdo -> query($sql);
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     echo $row . "<br>";
                echo "<hr>";
                 }  */
       ?> 
       

    </body> 
</html>