# HotPepperSearch
ホットペッパーAPIを利用した飲食店検索サイト
- テスト環境 MAMP
- PHP ver8.0
- URL https://hotpepper-website.herokuapp.com/

利用したパッケージ
- https://github.com/superRaytin/paginationjs (ページ送り)
- bootstrap5.0
- ホットペッパーAPI


クラスの関数について
## set_data()
ユーザーがセットした値を連想配列に入れる。
返り値は連想配列。

## create_url()
APIリクエスト送信用URLの作成関数。
セッターの返り値を入れる。
返り値は文字列。

## get_data()
URLでリクエストを送る。
返り値はjson形式。

## 処理について




