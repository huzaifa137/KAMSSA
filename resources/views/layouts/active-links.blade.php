<ul class="nav panel-tabs">
    <?php $currentUrl = url()->current();?>
    
    @foreach ($links as $key => $link)
        <li>
            <a class="{{ $currentUrl === url($link['link_address']) ? 'active' : '' }}"
                href="{{ url($link['link_address']) }}">
                {{ $link['link_name'] }}
            </a>
        </li>
    @endforeach
</ul>