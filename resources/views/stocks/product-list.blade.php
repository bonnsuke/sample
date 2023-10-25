<!DOCTYPE html> <html lang="jp" class="h-100" > <head> <meta charset="UTF-8"> <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>商品一覧</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="{{ asset('style.css') }}" rel="stylesheet">
</head>

<body class="h-100">
    {{-- ヘッダー --}}
    <header class="w-100 d-flex justify-content-between align-items-center bg-light px-3 h_home">
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item mx-3 text-muted"><form action="/logout" method="post">@csrf <button type="submit">Logout</button></form></li>
        </ul>
        <div class="fs-1 fw-bolder">商品管理システム</div>
    </header>
    <div class="d-flex flex-row w-100" style="height: calc(100% - 50px)">
        {{-- サイドメニュー --}}
        <nav class="bg-dark n_home">
            {{-- メニュー内容 --}}
            <ul class="nav flex-column m-0 p-3">
                <li class="nav-item mb-2"><a href="/home" class="nav-link">HOME</a></li>
                @can('admin-higher'){{-- 管理者権限以上に表示される --}}
                <li class="nav-item mb-2"><a href="/registration" class="nav-link">商品登録</a></li>
                <li class="nav-item mb-2"><a href="/type" class="nav-link">種別登録</a></li>
                @endcan
            </ul>
        </nav>
        {{-- メインコンテンツ --}}
        <main class="w-100 bg-light m_home">
            {{-- タイトルバー --}}
            <div class="bg-light border shadow-sm d-flex flex-row align-items-center">
                <div class="navbar-brand toggle-menu">
                    <button class="btn btn-light btn-sm" id="toggle"><i class="fas fa-bars fa-lg"></i></button>
                </div>
                <div class="fs-4 fw-bold">Dashboard</div>
            </div>
<div class="tool">

    <form action="/list" class="search-form-006">
        <label>
            <input type="text" name="keyword" placeholder="キーワードを入力">
        </label>
        <button type="submit" aria-label="検索"></button>
    </form>
   
    @can('admin-higher'){{-- 管理者権限以上に表示される --}}
    <a href="/registration" class="btn btn-danger btn2">登録</a>
    @endcan

</div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">名前</th>
                <th scope="col">種別</th>
                <th scope="col">詳細</th>
                <th scope="col"></th>
            </tr>
            @foreach ($items as $value)
            </thead>
            <tbody>
            <tr> 
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->type->type_name}}</td>
                <td>{{ $value->detail }}</td>
                <td>
                    @can('admin-higher'){{-- 管理者権限以上に表示される --}}
                    <a href="/edit/{{$value->id}}" class="btn btn-outline-primary btn-sm" > 編集 </a>
                    @endcan
                </td>
            </tr>   
            </tbody>
            @endforeach
        </table>
        </table>
    </main>
</div>


</body>
<script type="text/javascript">
window.onload = () => {
    // toggleボタン
    let sidemenuToggle = document.getElementById('toggle')
    // メインコンテンツを囲むmain要素
    let page = document.getElementsByTagName('main')[0];
    // 表示状態 trueで表示中 falseで非表示
    let sidemenuStatus = false;
    page.style.cssText = 'margin-left: -230px'

    // ボタンクリック時のイベント
    sidemenuToggle.addEventListener('click', () => {
        // 表示状態を判定
        if (sidemenuStatus) {
            page.style.cssText = 'margin-left: -230px'
            sidemenuStatus = false;
        } else {
            page.style.cssText = 'margin-left: 0px'
            sidemenuStatus = true;
        }
    })
}
</script>

</html>