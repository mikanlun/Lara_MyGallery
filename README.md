# Lara_MyGallery

スライドショー（Laravelフレームワーク）

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
・Laravel Framework 6.19.1  

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
 
    ・ 適宜、ご変更をお願いします。  

　2.PERMISSIONS  
 
    ・ strageとbootstrap/cacheディレクトリにread, write 権限を設定してください。

　3.テーブルの作成  
 
    ・ マイグレートをおこなってください。

　４.シンボリックリンク  
 
    ・ public/storageからstorage/app/publicへシンボリックリンクを張ってください。
    
     php artisan storage:link
  　

## Author

@mikanlun

## License

[MIT](https://github.com/mikanlun/MyGallery/blob/master/LICENSE)
