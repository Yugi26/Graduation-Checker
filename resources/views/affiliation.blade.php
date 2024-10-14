<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学群・学類・専攻の選択</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>学群・学類・専攻の選択</h1>
    <form action="/check" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="faculty">学群:</label>
        <select id="faculty" name="faculty">
            <option value="">学群を選択</option>
            @foreach ($faculties as $faculty => $departments)
                <option value="{{ $faculty }}">{{ $faculty }}</option>
            @endforeach
        </select>

        <br><br>

        <label for="department">学類:</label>
        <select id="department" name="department" disabled>
            <option value="">先に学群を選択してください</option>
        </select>

        <br><br>

        <label for="major">専攻:</label>
        <select id="major" name="major" disabled>
            <option value="">先に学類を選択してください</option>
        </select>

        <br><br>

        <label for="csv_file">履修履歴CSV:</label>
        <input type="file" id="csv_file" name="csv_file" required>

        <br><br>

        <button type="submit">卒業要件を確認</button>
    </form>

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
