<tbody>
    @foreach($articles as $article)
        <tr>
            <td>{{ $article->content }}</td>
        </tr>
    @endforeach
</tbody>