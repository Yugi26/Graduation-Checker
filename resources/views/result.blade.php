<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>卒業要件判定結果</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h1>卒業要件判定結果</h1>

    <h2>必修科目</h2>
    <p>取得単位数: {{ $result['必修'] }} ({{ $requirements['必修']['required_units'] }}単位以上必要)</p>
    <p>判定: {{ $status['必修'] }}</p>

    <h2>選択科目</h2>
    <table border="1">
        <thead>
            <tr>
                <th>科目区分</th>
                <th>必要単位数</th>
                <th>取得単位数</th>
                <th>判定</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result['選択'] as $category => $units)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ $requirements['選択'][$category]['required_units'] }}</td>
                    <td>{{ $units }}</td>
                    <td class="{{ $status[$category] === '達成済' ? 'status-achieved' : '' }}">
                        {{ $status[$category] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>総修得単位数</h2>
    <p>取得単位数: {{ $result['総修得単位数'] }} ({{ $requirements['選択合計'] }}単位以上必要)</p>
    <h2>判定</h2>
    <h3>{{ $status['総修得単位数'] }}</h3>
</body>
</html>
