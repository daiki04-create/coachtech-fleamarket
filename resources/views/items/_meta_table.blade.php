<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
        <th style="text-align: left; padding: 10px; border-bottom: 1px solid #eee;">カテゴリー</th>
        <td style="padding: 10px; border-bottom: 1px solid #eee;">
            @foreach($item->categories as $category)
                <span style="background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 12px; margin-right: 5px;">
                    {{ $category->name }}
                </span>
            @endforeach
        </td>
    </tr>
    <tr>
        <th style="text-align: left; padding: 10px; border-bottom: 1px solid #eee;">商品の状態</th>
        <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $item->condition }}</td>
    </tr>
</table>