<table class="highlight">
    <tbody>
    @foreach($posts as $post)
        <tr>
            <td>
                <a href="{{$post->url}}">
                    <ul>
                        <li>
                            <p class="post-title">{{ $post->title }}</p>
                        </li>
                    </ul>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


