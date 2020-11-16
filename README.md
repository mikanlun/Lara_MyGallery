# Lara_MyGallery

スライドショー

## Description

どなたでも、自由にアルバムを作成することができます。  
スライドショーで写真を楽しめます。

***SAMPLE:***

![lara_mygallery](https://user-images.githubusercontent.com/36429862/99235645-74a2b800-2839-11eb-9f9e-52f13116bd65.png)
## Features

・複数ユーザーの画像のスライドショー（認証済みの時は、認証ユーザーのみ表示）  
・複数ユーザーの画像のサムネイル（カルーセル）表示（認証済みの時は、認証ユーザーのみ表示）  
・画像の個別表示（スライドショー及びサムネイルの画像をクリックで表示）  

## Requirement

・CentOS 7.4  
・PHP 7.2  
・mysql 5.7  
・Laravel 6.19
・slick 1.8  
・bootstrap 4.0  

## Usage

1.画像の処理  
　・画像の登録（メニューバーのユーザー名のプルダウンメニューより）（認証済みの時）  
　・画像の編集（スライドショー及びサムネイルの画像をクリックで表示 -> 編集）（認証済みの時）  
　・画像の削除（スライドショー及びサムネイルの画像をクリックで表示 -> 編集 -> 削除）（認証済みの時）  
2.アカウント  
　・ログイン（メニューバーより）  
　・ログアウト（メニューバーのユーザー名のプルダウンメニューより）（認証済みの時）  
　・ユーザーの新規登録（メニューバーより）  
　・ユーザーの編集、退会(削除)  
   （メニューバーのユーザー名のプルダウンメニューのアカウントより）（認証済みの時）  
3.その他  
　・about（メニューバーより）  
　・お問い合わせ（メニューバーより）  

## Settings

　1.env ファイルの設定  
 
    ・データベース接続  
        dbname、user、passwordの設定をしてください。
        /src/functions/function.php 41行
       function connectDb() {
           try {
               $dsn = "mysql:host=localhost;dbname=dbname";
               $user = "user";
               $password = "password";

               $dbh = new PDO($dsn, $user, $password);
               return $dbh;
           } catch(PDOException $e) {
               echo "DB accsess error ! : " . $e->getMessage();
               exit();
           }
       }

　2.テーブルの作成  
 
    ・ユーザーテーブル（users）
        CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(255) DEFAULT NULL,
          `sex` char(1) DEFAULT '1',
          `birthday` varchar(255) DEFAULT NULL,
          `zip` varchar(255) DEFAULT NULL,
          `address` varchar(255) DEFAULT NULL,
          `tel` varchar(255) DEFAULT NULL,
          `email` varchar(255) DEFAULT NULL,
          `password` varchar(255) DEFAULT NULL,
          `profile` text,
          `created` datetime DEFAULT NULL,
          `modified` datetime DEFAULT NULL,
          PRIMARY KEY (`id`));

    ・アルバムテーブル（albums）  
        CREATE TABLE `albums` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` int(11) DEFAULT NULL,
          `title` varchar(255) DEFAULT NULL,
          `path` varchar(255) DEFAULT NULL,
          `image` varchar(255) DEFAULT NULL,
          `comment` text,
          `created` datetime DEFAULT NULL,
          `modified` datetime DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`));

　3.メールアドレスの設定  

    "admin@example.jp"を変更してください。  
    /app/config/define.php 4行  
    $support_email = "admin@example.jp";   

　4.ドキュメントルート  
 　・ドキュメントルートは、 'gallery' に設定してください。 

　5.ディレクトリのオーナの設定  
 　・画像保存のディレクトリ images のオーナをwebサーバーの実行ユーザーに設定してください。  
    
    /images

　6.エントリーポイント  
 
    /index.php


## Author

@mikanlun

## License

[MIT](https://github.com/mikanlun/MyGallery/blob/master/LICENSE)