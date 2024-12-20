<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>筑波大学大学院 卒業判定</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h1>筑波大学大学院 卒業判定</h1>
    <form action="/check" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="faculty">学術院:</label>
        <select id="faculty" name="faculty">
            <option value="">学術院を選択</option>
            @foreach ($faculties as $faculty => $departments)
                <option value="{{ $faculty }}">{{ $faculty }}</option>
            @endforeach
        </select>

        <br><br>

        <label for="department">研究群:</label>
        <select id="department" name="department" disabled>
            <option value="">先に学術院を選択してください</option>
        </select>

        <br><br>

        <label for="major">学位プログラム:</label>
        <select id="major" name="major" disabled>
            <option value="">先に研究群を選択してください</option>
        </select>

        <br><br>

        <label for="csv_file">履修履歴CSV:</label>
        <input type="file" id="csv_file" name="csv_file" required>
        <p>
            履修履歴ファイルは
            <a href="https://twins.tsukuba.ac.jp/campusweb/campusportal.do?page=main&tabId=si" target="_blank" rel="noopener noreferrer">
                TWINS
            </a>
            の成績ページでダウンロードできます。形式はCSV、日本語（シフトJIS）にしてください。
        </p>

        <button type="submit">卒業要件を確認</button>

        <br><br>
    </form>

    <footer>
        <p>※履修履歴CSVはデータベースには保存されず、メモリ上で処理後に削除されます。</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('#faculty').on('change', function() {
                const faculty = $(this).val();
                if (faculty) {
                    $.get('/departments', { faculty: faculty })
                        .done(function(data) {
                            console.log(data); // データの確認
                            $('#department').empty().append('<option value="">学類を選択</option>');
                            data.forEach(function(department) {
                                $('#department').append(`<option value="${department}">${department}</option>`);
                            });
                            $('#department').prop('disabled', false);
                        })
                        .fail(function() {
                            alert('学類の取得に失敗しました。');
                        });
                } else {
                    $('#department').empty().append('<option value="">先に学群を選択してください</option>').prop('disabled', true);
                    $('#major').empty().append('<option value="">先に学類を選択してください</option>').prop('disabled', true);
                }
            });

            $('#department').on('change', function() {
                const department = $(this).val();
                if (department) {
                    $.get('/majors', { department: department })
                        .done(function(data) {
                            console.log(data); // データの確認
                            $('#major').empty().append('<option value="">専攻を選択</option>');
                            data.forEach(function(major) {
                                $('#major').append(`<option value="${major}">${major}</option>`);
                            });
                            $('#major').prop('disabled', false);
                        })
                        .fail(function() {
                            alert('専攻の取得に失敗しました。');
                        });
                } else {
                    $('#major').empty().append('<option value="">先に学類を選択してください</option>').prop('disabled', true);
                }
            });
        });
    </script>
</body>
</html>
